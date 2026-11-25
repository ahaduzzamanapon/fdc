<?php

namespace App\Services;

use App\Models\FilmPackage;
use App\Models\Booking;
use App\Models\Package;
use App\Models\FilmApplication;
use App\Models\Producer;
use App\Models\Noc;
use App\Models\PaymentRefund;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BfdcAccountingService
{
    protected string $baseUrl;
    protected ?string $username;
    protected ?string $password;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.bfdc_accounting.base_url', 'http://localhost:12032'), '/');
        $this->username = config('services.bfdc_accounting.username');
        $this->password = config('services.bfdc_accounting.password');
    }

    /**
     * Get or refresh Bearer JWT token from BFDC Accounting API.
     */
    public function getAuthToken(bool $forceRefresh = false): ?string
    {
        $cacheKey = 'bfdc_accounting_jwt_token';

        if (!$forceRefresh && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        if (empty($this->username) || empty($this->password)) {
            return null;
        }

        try {
            $response = Http::timeout(10)->post("{$this->baseUrl}/api/v1/auth/login", [
                'username' => $this->username,
                'password' => $this->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $token = $data['token'] ?? null;
                if ($token) {
                    Cache::put($cacheKey, $token, now()->addMinutes(400));
                    return $token;
                }
            }
        } catch (\Throwable $e) {
            Log::warning('BFDC Accounting Auth Exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Perform authenticated request to external BFDC Accounting API.
     */
    protected function request(string $method, string $endpoint, array $payload = [], ?string $correlationId = null)
    {
        $token = $this->getAuthToken();
        $correlationId = $correlationId ?: (string) Str::uuid();

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Correlation-Id' => $correlationId,
        ];

        if ($token) {
            $headers['Authorization'] = "Bearer {$token}";
        }

        $url = "{$this->baseUrl}{$endpoint}";
        $response = Http::withHeaders($headers)->timeout(15)->$method($url, $payload);

        if ($response->status() === 401) {
            $token = $this->getAuthToken(true);
            if ($token) {
                $headers['Authorization'] = "Bearer {$token}";
                $response = Http::withHeaders($headers)->timeout(15)->$method($url, $payload);
            }
        }

        return $response;
    }

    /**
     * Map arbitrary or Bengali shift string into Subrahost canonical shift.
     * Allowed: Morning, Evening, Night, Both, Monthly.
     */
    public function mapShiftName(?string $rawShift): string
    {
        if (empty($rawShift)) {
            return 'Morning';
        }

        $s = mb_strtolower(trim($rawShift), 'UTF-8');

        if (str_contains($s, 'morning') || str_contains($s, 'সকাল') || str_contains($s, 'day') || str_contains($s, 'দিন')) {
            return 'Morning';
        }
        if (str_contains($s, 'evening') || str_contains($s, 'বিকাল') || str_contains($s, 'সন্ধ্যা')) {
            return 'Evening';
        }
        if (str_contains($s, 'night') || str_contains($s, 'রাত')) {
            return 'Night';
        }
        if (str_contains($s, 'both') || str_contains($s, 'উভয়')) {
            return 'Both';
        }
        if (str_contains($s, 'month') || str_contains($s, 'মাস')) {
            return 'Monthly';
        }

        return 'Morning';
    }

    // =========================================================================
    // 1. PARTY API (POST /api/v1/party)
    // =========================================================================

    /**
     * Push a Film/Application (Party) record to Accounting API upon approval or manual trigger.
     */
    public function pushFilmApplicationToAccounting(FilmApplication $film): array
    {
        $correlationId = (string) Str::uuid();

        // 1. Resolve Banner (Application's organization name takes top priority matching MIS table)
        $banner = $film->organization_name ?: ($film->banner_name ?: null);
        $producer = $film->producer ?: Producer::find($film->producer_id);
        if (empty($banner)) {
            $banner = $producer ? ($producer->organization_name ?: $producer->owners_name) : 'General Banner';
        }

        $filmTitle = $film->film_title ?: 'Untitled Project';
        $producerName = $film->applicant_name ?: ($producer ? ($producer->owners_name ?: $producer->organization_name) : 'General Producer');
        $category = $film->category ?: 'film';
        $eventType = 'Film'; // Subrahost strictly validates EventType: 'Film' or 'Advertise'

        // Subrahost GUID: fdc00000-0000-0000-[producer_id]-[application_id]
        $prodId = (int) ($film->producer_id ?: 1);
        $appId = (int) $film->id;
        $clientRequestId = sprintf("fdc00000-0000-0000-%04x-%012x", $prodId, $appId);

        $nowIso = date('c');

        try {
            $payload = [
                'eventType' => $eventType,
                'banner' => $banner,
                'film' => $filmTitle,
                'producer' => $producerName,
                'startDate' => $nowIso,
                'openingDebit' => 0.0,
                'openingCredit' => 0.0,
                'type' => 'Party',
                'category' => $category,
                'releaseDate' => $nowIso,
                'remarks' => "Approved {$category} application (App #{$appId}) from BFDC MIS",
                'clientRequestId' => $clientRequestId,
            ];

            $response = $this->request('post', '/api/v1/party', $payload, $correlationId);
            $isSuccess = $response->successful() || $response->status() === 409;

            return [
                'success' => $isSuccess,
                'status' => $response->status(),
                'data' => $response->json(),
                'filmId' => $film->id,
                'banner' => $banner,
                'film' => $filmTitle,
                'category' => $category,
            ];
        } catch (\Throwable $e) {
            Log::error('FilmApplication Accounting push error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'filmId' => $film->id,
            ];
        }
    }

    // =========================================================================
    // 2. RATE CARD API (POST /api/v1/rate-card)
    // =========================================================================

    /**
     * Push a Rate Card entry to Accounting API upon Item create/update or manual push.
     */
    public function pushRateCardToAccounting(\App\Models\Item $item, ?string $shift = null): array
    {
        $correlationId = (string) Str::uuid();
        $section = $item->category ? ($item->category->name_bn ?: $item->category->name_en) : 'General Section';
        $subSection = $item->name_bn ?: ($item->name_en ?: "Item-{$item->id}");

        // Auto-detect shift or fallback to Morning
        if (empty($shift)) {
            $itemShift = \App\Models\Shift::where('item_id', $item->id)->first();
            $rawShift = $itemShift ? ($itemShift->name ?: 'Morning') : 'Morning';
            $shift = $this->mapShiftName($rawShift);
        } else {
            $shift = $this->mapShiftName($shift);
        }

        $generalRate = (float) ($item->amount ?: 0);
        $include15PercentRate = $generalRate; // সিস্টেমে ১টি প্রাইস থাকলে দুটোই সমান

        // Subrahost GUID: fdc00000-0000-0000-0000-[item_id]
        $hexId = str_pad(dechex((int) $item->id), 12, '0', STR_PAD_LEFT);
        $clientRequestId = "fdc00000-0000-0000-0000-{$hexId}";

        try {
            $payload = [
                'section' => $section,
                'subSection' => $subSection,
                'shift' => $shift,
                'generalRate' => $generalRate,
                'include15PercentRate' => $include15PercentRate,
                'clientRequestId' => $clientRequestId,
            ];

            $response = $this->request('post', '/api/v1/rate-card', $payload, $correlationId);
            $isSuccess = $response->successful() || $response->status() === 409;

            return [
                'success' => $isSuccess,
                'status' => $response->status(),
                'data' => $response->json(),
                'itemId' => $item->id,
                'section' => $section,
                'subSection' => $subSection,
                'shift' => $shift,
            ];
        } catch (\Throwable $e) {
            Log::error('Rate-card Accounting push error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'itemId' => $item->id,
            ];
        }
    }

    // =========================================================================
    // 3. BILLING & COLLECTION APIS (Payment Auto-Push)
    // =========================================================================

    /**
     * Format a FilmPackage into structured payload for Billing & Collection APIs.
     */
    public function formatPaymentData(FilmPackage $filmPackage): array
    {
        $banner = 'General Banner';
        $filmTitle = 'General Film';
        $producerName = 'Producer';
        $bookingRemarks = null;
        $bookingDate = $filmPackage->paid_at ? date('c', strtotime($filmPackage->paid_at)) : date('c');
        $shift = null;
        $bookingId = null;
        $lineItems = [];

        if ($filmPackage->type === 'booking') {
            $booking = Booking::with(['details.item.unit', 'details.item.category', 'details.shift', 'film', 'producer'])->find($filmPackage->package_id);
            if ($booking) {
                $bookingId = $booking->id;
                if ($booking->created_at) {
                    $bookingDate = $booking->created_at->format('c');
                }
                if ($booking->film) {
                    $filmTitle = $booking->film->film_title ?: $filmTitle;
                    $banner = $booking->film->organization_name ?: ($booking->film->banner_name ?: $banner);
                    $producerName = $booking->film->applicant_name ?: $producerName;
                }
                if ($booking->producer) {
                    if (empty($banner) || $banner === 'General Banner') {
                        $banner = $booking->producer->organization_name ?: ($booking->producer->owners_name ?: $banner);
                    }
                    if (empty($producerName) || $producerName === 'Producer') {
                        $producerName = $booking->producer->owners_name ?: ($booking->producer->organization_name ?: $producerName);
                    }
                }

                $bookingRemarks = $booking->remarks ?: ("Booking #{$booking->id}" . ($booking->book_id ? " ({$booking->book_id})" : ""));

                if ($booking->details && count($booking->details) > 0) {
                    foreach ($booking->details as $d) {
                        $itemUnit = 'Shift';
                        if ($d->item && $d->item->unit) {
                            $itemUnit = $d->item->unit->name_en ?: ($d->item->unit->name_bn ?: 'Shift');
                        }

                        $sectionName = 'General Section';
                        if ($d->item && $d->item->category) {
                            $sectionName = $d->item->category->name_bn ?: ($d->item->category->name_en ?: 'General Section');
                        } elseif (!empty($d->catagori)) {
                            $sectionName = $d->catagori;
                        }

                        $subSectionName = $d->item ? ($d->item->name_bn ?: ($d->item->name_en ?: "Item-{$d->item_id}")) : 'General Item';

                        if (empty($shift) && $d->shift && !empty($d->shift->name)) {
                            $shift = $this->mapShiftName($d->shift->name);
                        }

                        $lineItems[] = [
                            'section' => $sectionName,
                            'subSection' => $subSectionName,
                            'rateType' => 'GeneralRate',
                            'rate' => (float) ($d->amount ?: 0),
                            'unit' => $itemUnit,
                            'quantity' => (float) ($d->total_day ?: 1),
                        ];
                    }
                }
            }
        } else {
            $package = Package::with(['details.item.unit', 'details.item.category', 'film', 'producer'])->find($filmPackage->package_id);
            if ($package) {
                $bookingId = $package->id;
                if ($package->created_at) {
                    $bookingDate = $package->created_at->format('c');
                }
                if ($package->film) {
                    $filmTitle = $package->film->film_title ?: $filmTitle;
                    $banner = $package->film->organization_name ?: ($package->film->banner_name ?: $banner);
                    $producerName = $package->film->applicant_name ?: $producerName;
                }
                if ($package->producer) {
                    if (empty($banner) || $banner === 'General Banner') {
                        $banner = $package->producer->organization_name ?: ($package->producer->owners_name ?: $banner);
                    }
                    if (empty($producerName) || $producerName === 'Producer') {
                        $producerName = $package->producer->owners_name ?: ($package->producer->organization_name ?: $producerName);
                    }
                }

                $bookingRemarks = "Package: " . ($package->name ?: "#{$package->id}");

                if ($package->details && count($package->details) > 0) {
                    foreach ($package->details as $pd) {
                        $itemUnit = 'Shift';
                        if ($pd->item && $pd->item->unit) {
                            $itemUnit = $pd->item->unit->name_en ?: ($pd->item->unit->name_bn ?: 'Shift');
                        }

                        $sectionName = 'Package Section';
                        if ($pd->item && $pd->item->category) {
                            $sectionName = $pd->item->category->name_bn ?: ($pd->item->category->name_en ?: 'Package Section');
                        }

                        $subSectionName = $pd->item ? ($pd->item->name_bn ?: ($pd->item->name_en ?: 'Package Item')) : 'Package Item';

                        $lineItems[] = [
                            'section' => $sectionName,
                            'subSection' => $subSectionName,
                            'rateType' => 'GeneralRate',
                            'rate' => (float) ($pd->item_amt ?: ($pd->request_total_amt ?: 0)),
                            'unit' => $itemUnit,
                            'quantity' => (float) ($pd->request_days ?: ($pd->app_days ?: 1)),
                        ];
                    }
                }
            }
        }

        if (empty($lineItems)) {
            $lineItems[] = [
                'section' => 'Service',
                'subSection' => $filmPackage->name ?: 'Booking Package Fee',
                'rateType' => 'GeneralRate',
                'rate' => (float) $filmPackage->amount,
                'unit' => 'Shift',
                'quantity' => 1,
            ];
        }

        $mrNo = $filmPackage->TrxID ?: ($filmPackage->trn_id ?: "MR-{$filmPackage->id}");
        $collectionDate = $filmPackage->paid_at ? date('c', strtotime($filmPackage->paid_at)) : date('c');

        return [
            'mrNo' => $mrNo,
            'collectionDate' => $collectionDate,
            'collectionAmount' => (float) $filmPackage->amount,
            'status' => $filmPackage->status,
            'banner' => $banner,
            'filmName' => $filmTitle,
            'producer' => $producerName,
            'bookingId' => $bookingId,
            'bookingRemarks' => $bookingRemarks,
            'shift' => $shift,
            'billDate' => $bookingDate,
            'lineItems' => $lineItems,
        ];
    }

    /**
     * Push billing and collection to BFDC Accounting API upon successful payment.
     * Only calls Billing and Collection (Party and Rate-card already pushed previously).
     */
    public function pushToAccounting(FilmPackage $filmPackage): array
    {
        $correlationId = (string) Str::uuid();
        $formatted = $this->formatPaymentData($filmPackage);

        // Subrahost GUID: fdc00000-0000-0000-[type_id]-[id]
        $bkId = (int) ($formatted['bookingId'] ?: $filmPackage->id);
        $fpId = (int) $filmPackage->id;
        $billClientRequestId = sprintf("fdc00000-0000-0000-0001-%012x", $bkId);
        $colClientRequestId = sprintf("fdc00000-0000-0000-0002-%012x", $fpId);

        try {
            // 1. Billing API Push (POST /api/v1/billing)
            $billingPayload = [
                'billDate' => $formatted['billDate'],
                'banner' => $formatted['banner'],
                'filmName' => $formatted['filmName'],
                'remarks' => $formatted['bookingRemarks'] ?: "Booking payment Trx: {$formatted['mrNo']}",
                'lineItems' => $formatted['lineItems'],
                'clientRequestId' => $billClientRequestId,
            ];

            if (!empty($formatted['shift'])) {
                $billingPayload['shift'] = $formatted['shift'];
            }

            $billResponse = $this->request('post', '/api/v1/billing', $billingPayload, $correlationId);

            // 2. Collection API Push (POST /api/v1/collection)
            $colPayload = [
                'collectionDate' => $formatted['collectionDate'],
                'banner' => $formatted['banner'],
                'filmName' => $formatted['filmName'],
                'mrNo' => $formatted['mrNo'],
                'collectionAmount' => $formatted['collectionAmount'],
                'clientRequestId' => $colClientRequestId,
            ];

            $colResponse = $this->request('post', '/api/v1/collection', $colPayload, $correlationId);

            $isSuccess = ($colResponse->successful() || $colResponse->status() === 409) &&
                         ($billResponse->successful() || $billResponse->status() === 409);

            return [
                'success' => $isSuccess,
                'status' => $colResponse->status(),
                'billStatus' => $billResponse->status(),
                'data' => $colResponse->json(),
                'billData' => $billResponse->json(),
                'mrNo' => $formatted['mrNo'],
            ];
        } catch (\Throwable $e) {
            Log::error('Accounting push error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'mrNo' => $formatted['mrNo'],
            ];
        }
    }

    // =========================================================================
    // 4. NOC PAYMENT PUSH
    // =========================================================================

    /**
     * Push a NOC payment (Billing & Collection) to BFDC Accounting API.
     */
    public function pushNocToAccounting(Noc $noc): array
    {
        $correlationId = (string) Str::uuid();
        $mrNo = $noc->trx_id ?: ($noc->token ?: "NOC-{$noc->id}");
        $amount = (float) ($noc->amount ?: 0);

        if ($amount <= 0) {
            return [
                'success' => false,
                'error' => 'NOC collection amount must be greater than zero.',
                'mrNo' => $mrNo,
            ];
        }

        $date = $noc->updated_at ? $noc->updated_at->format('c') : ($noc->created_at ? $noc->created_at->format('c') : date('c'));
        $banner = $noc->organization ?: ($noc->producer ?: 'General Organization');
        $filmOrWork = $noc->name ?: 'NOC Certificate Application';

        $nocId = (int) $noc->id;
        $billClientRequestId = sprintf("fdc00000-0000-0000-0003-%012x", $nocId);
        $colClientRequestId = sprintf("fdc00000-0000-0000-0004-%012x", $nocId);

        try {
            // 1. Billing API Push
            $billResponse = $this->request('post', '/api/v1/billing', [
                'billDate' => $date,
                'banner' => $banner,
                'filmName' => $filmOrWork,
                'shift' => 'Morning',
                'remarks' => "NOC Fee Trx: {$mrNo}",
                'clientRequestId' => $billClientRequestId,
                'lineItems' => [
                    [
                        'section' => 'Certificate',
                        'subSection' => 'NOC Application Fee',
                        'rateType' => 'GeneralRate',
                        'rate' => $amount,
                        'unit' => 'Shift',
                        'quantity' => 1,
                    ]
                ],
            ], $correlationId);

            // 2. Collection API Push
            $colResponse = $this->request('post', '/api/v1/collection', [
                'collectionDate' => $date,
                'banner' => $banner,
                'filmName' => $filmOrWork,
                'mrNo' => $mrNo,
                'collectionAmount' => $amount,
                'clientRequestId' => $colClientRequestId,
            ], $correlationId);

            $isSuccess = ($colResponse->successful() || $colResponse->status() === 409) &&
                         ($billResponse->successful() || $billResponse->status() === 409);

            return [
                'success' => $isSuccess,
                'status' => $colResponse->status(),
                'billStatus' => $billResponse->status(),
                'data' => $colResponse->json(),
                'mrNo' => $mrNo,
            ];
        } catch (\Throwable $e) {
            Log::error('NOC Accounting push error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'mrNo' => $mrNo,
            ];
        }
    }

    // =========================================================================
    // 5. REFUND PUSH (REVERSAL COLLECTION)
    // =========================================================================

    /**
     * Push Payment Refund record to Accounting system (Adjustment Collection).
     */
    public function pushRefundToAccounting(PaymentRefund $refund): array
    {
        $correlationId = (string) Str::uuid();
        $filmPackage = FilmPackage::find($refund->payment_id);

        $banner = 'General Banner';
        $filmTitle = 'General Film';
        $mrNo = ($filmPackage && $filmPackage->bank_payment_id) ? $filmPackage->bank_payment_id : $refund->trn_id;
        $refundDate = $refund->created_at ? $refund->created_at->format('c') : date('c');
        $refundAmount = (float) $refund->amount;
        $chargeAmount = (float) $refund->charge;

        if ($filmPackage) {
            if ($filmPackage->type === 'booking') {
                $booking = Booking::with(['film', 'producer'])->find($filmPackage->package_id);
                if ($booking) {
                    if ($booking->film) {
                        $banner = $booking->film->organization_name ?: ($booking->film->banner_name ?: $banner);
                        $filmTitle = $booking->film->film_title ?: $filmTitle;
                    }
                    if ($booking->producer && (empty($banner) || $banner === 'General Banner')) {
                        $banner = $booking->producer->organization_name ?: ($booking->producer->owners_name ?: $banner);
                    }
                }
            } else {
                $package = Package::with(['film', 'producer'])->find($filmPackage->package_id);
                if ($package) {
                    if ($package->film) {
                        $banner = $package->film->organization_name ?: ($package->film->banner_name ?: $banner);
                        $filmTitle = $package->film->film_title ?: $filmTitle;
                    }
                    if ($package->producer && (empty($banner) || $banner === 'General Banner')) {
                        $banner = $package->producer->organization_name ?: ($package->producer->owners_name ?: $banner);
                    }
                }
            }
        }

        $refundId = (int) $refund->id;
        $colClientRequestId = sprintf("fdc00000-0000-0000-0005-%012x", $refundId);

        try {
            $refundPayload = [
                'collectionDate' => $refundDate,
                'banner' => $banner,
                'filmName' => $filmTitle,
                'mrNo' => "RFD-{$mrNo}",
                'collectionAmount' => -$refundAmount, // Negative amount for accounting adjustment
                'clientRequestId' => $colClientRequestId,
            ];

            $response = $this->request('post', '/api/v1/collection', $refundPayload, $correlationId);
            $isSuccess = $response->successful() || $response->status() === 409;

            return [
                'success' => $isSuccess,
                'status' => $response->status(),
                'data' => $response->json(),
                'refundId' => $refund->id,
                'trn_id' => $refund->trn_id,
            ];
        } catch (\Throwable $e) {
            Log::error('Refund Accounting push error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'refundId' => $refund->id,
                'trn_id' => $refund->trn_id,
            ];
        }
    }
}
