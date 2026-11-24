<?php

namespace App\Services;

use App\Models\FilmPackage;
use App\Models\Booking;
use App\Models\Package;
use App\Models\FilmApplication;
use App\Models\Producer;
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
     * Format a FilmPackage into full payload matching BFDC doc + extra audit fields.
     */
    public function formatPaymentData(FilmPackage $filmPackage): array
    {
        $banner = 'General Banner';
        $filmTitle = 'General Film';
        $producerName = 'Producer';
        $producerPhone = null;
        $jobReportNo = $filmPackage->trn_id ?: "JOB-{$filmPackage->id}";
        $lineItems = [];

        if ($filmPackage->type === 'booking') {
            $booking = Booking::with(['details.item', 'details.shift', 'film', 'producer'])->find($filmPackage->package_id);
            if ($booking) {
                $jobReportNo = $booking->book_id ?: "BKG-{$booking->id}";
                if ($booking->producer) {
                    $banner = $booking->producer->organization_name ?: ($booking->producer->owners_name ?: $banner);
                    $producerName = $booking->producer->owners_name ?: ($booking->producer->organization_name ?: $producerName);
                    $producerPhone = $booking->producer->phone_number;
                }
                if ($booking->film) {
                    $filmTitle = $booking->film->film_title ?: $filmTitle;
                    if (empty($banner) || $banner === 'General Banner') {
                        $banner = $booking->film->banner_name ?: ($booking->film->organization_name ?: $banner);
                    }
                    if (empty($producerName) || $producerName === 'Producer') {
                        $producerName = $booking->film->applicant_name ?: $producerName;
                    }
                }

                if ($booking->details && count($booking->details) > 0) {
                    foreach ($booking->details as $d) {
                        $shiftName = 'Morning';
                        if ($d->shift && !empty($d->shift->name)) {
                            $sn = strtolower($d->shift->name);
                            if (str_contains($sn, 'even')) $shiftName = 'Evening';
                            elseif (str_contains($sn, 'night')) $shiftName = 'Night';
                            elseif (str_contains($sn, 'both')) $shiftName = 'Both';
                            elseif (str_contains($sn, 'month')) $shiftName = 'Monthly';
                        }

                        $lineItems[] = [
                            'section' => $d->catagori ?: ($d->item ? $d->item->name_en : 'General Section'),
                            'subSection' => $d->item ? $d->item->name_en : 'General Item',
                            'rateType' => 'GeneralRate',
                            'rate' => (float) ($d->amount ?: 0),
                            'unit' => 'Shift',
                            'quantity' => (float) ($d->total_day ?: 1),
                        ];
                    }
                }
            }
        } else {
            $package = Package::with(['details.item', 'film', 'producer'])->find($filmPackage->package_id);
            if ($package) {
                $jobReportNo = $package->trn_id ?: ($package->name ?: "PKG-{$package->id}");
                if ($package->producer) {
                    $banner = $package->producer->organization_name ?: ($package->producer->owners_name ?: $banner);
                    $producerName = $package->producer->owners_name ?: ($package->producer->organization_name ?: $producerName);
                    $producerPhone = $package->producer->phone_number;
                }
                if ($package->film) {
                    $filmTitle = $package->film->film_title ?: $filmTitle;
                    if (empty($banner) || $banner === 'General Banner') {
                        $banner = $package->film->banner_name ?: ($package->film->organization_name ?: $banner);
                    }
                    if (empty($producerName) || $producerName === 'Producer') {
                        $producerName = $package->film->applicant_name ?: $producerName;
                    }
                }

                if ($package->details && count($package->details) > 0) {
                    foreach ($package->details as $pd) {
                        $lineItems[] = [
                            'section' => $pd->item ? ($pd->item->category ? $pd->item->category->name_en : 'Package Section') : 'Package Section',
                            'subSection' => $pd->item ? $pd->item->name_en : 'Package Item',
                            'rateType' => 'GeneralRate',
                            'rate' => (float) ($pd->item_amt ?: ($pd->request_total_amt ?: 0)),
                            'unit' => 'Shift',
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
        $date = $filmPackage->paid_at ? date('Y-m-d', strtotime($filmPackage->paid_at)) : date('Y-m-d');

        return [
            // Standard Accounting fields (matching BFDC Doc)
            'mrNo' => $mrNo,
            'collectionDate' => $date,
            'collectionAmount' => (float) $filmPackage->amount,
            'status' => $filmPackage->status,
            'banner' => $banner,
            'filmName' => $filmTitle,
            'producer' => $producerName,
            'jobReportNo' => $jobReportNo,
            'billDate' => $date,
            'lineItems' => $lineItems,

            // Safe extra fields for analysis & audit
            'auditTrail' => [
                'trn_id' => $filmPackage->trn_id,
                'TrxID' => $filmPackage->TrxID,
                'package_id' => $filmPackage->package_id,
                'type' => $filmPackage->type,
                'producerContact' => $producerPhone,
                'paidAt' => $filmPackage->paid_at,
            ]
        ];
    }

    /**
     * Push collection and required dependencies to BFDC Accounting API.
     */
    public function pushToAccounting(FilmPackage $filmPackage): array
    {
        $correlationId = (string) Str::uuid();
        $formatted = $this->formatPaymentData($filmPackage);

        try {
            // 1. Ensure Party
            $this->request('post', '/api/v1/party', [
                'eventType' => 'Film',
                'banner' => $formatted['banner'],
                'film' => $formatted['filmName'],
                'producer' => $formatted['producer'],
                'type' => 'Party',
                'clientRequestId' => (string) Str::uuid(),
            ], $correlationId);

            // 2. Ensure Rate Cards for line items
            if (!empty($formatted['lineItems'])) {
                foreach ($formatted['lineItems'] as $itemLine) {
                    $rateVal = (float) ($itemLine['rate'] ?? 0);
                    $this->request('post', '/api/v1/rate-card', [
                        'section' => $itemLine['section'] ?? 'General Section',
                        'subSection' => $itemLine['subSection'] ?? 'General Item',
                        'shift' => 'Morning',
                        'generalRate' => $rateVal,
                        'include15PercentRate' => $rateVal,
                        'clientRequestId' => (string) Str::uuid(),
                    ], $correlationId);
                }
            }

            // 3. Ensure Bill
            $this->request('post', '/api/v1/billing', [
                'billDate' => $formatted['billDate'],
                'jobReportNo' => $formatted['jobReportNo'],
                'banner' => $formatted['banner'],
                'filmName' => $formatted['filmName'],
                'shift' => 'Morning',
                'remarks' => "Payment Trx: {$formatted['mrNo']}",
                'clientRequestId' => (string) Str::uuid(),
                'lineItems' => $formatted['lineItems'],
            ], $correlationId);

            // 3. Collection Push
            $colResponse = $this->request('post', '/api/v1/collection', [
                'collectionDate' => $formatted['collectionDate'],
                'banner' => $formatted['banner'],
                'filmName' => $formatted['filmName'],
                'mrNo' => $formatted['mrNo'],
                'collectionAmount' => $formatted['collectionAmount'],
                'clientRequestId' => (string) Str::uuid(),
            ], $correlationId);

            $isSuccess = $colResponse->successful() || $colResponse->status() === 409;

            return [
                'success' => $isSuccess,
                'status' => $colResponse->status(),
                'data' => $colResponse->json(),
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

    /**
     * Push a NOC payment to BFDC Accounting API.
     */
    public function pushNocToAccounting(\App\Models\Noc $noc): array
    {
        $correlationId = (string) Str::uuid();
        $mrNo = $noc->trx_id ?: ($noc->token ?: "NOC-{$noc->id}");
        $amount = (float) ($noc->amount ?: 0);

        if ($amount <= 0) {
            return [
                'success' => false,
                'error' => 'NOC collection amount must be greater than zero to sync with Accounting.',
                'mrNo' => $mrNo,
            ];
        }

        $date = $noc->updated_at ? $noc->updated_at->format('Y-m-d') : ($noc->created_at ? $noc->created_at->format('Y-m-d') : date('Y-m-d'));
        $banner = $noc->organization ?: ($noc->producer ?: 'General Organization');
        $filmOrWork = $noc->name ?: 'NOC Certificate Application';
        $producer = $noc->producer ?: ($noc->full_name ?: 'Applicant');

        try {
            // 1. Ensure Party
            $this->request('post', '/api/v1/party', [
                'eventType' => 'Film',
                'banner' => $banner,
                'film' => $filmOrWork,
                'producer' => $producer,
                'type' => 'Party',
                'clientRequestId' => (string) Str::uuid(),
            ], $correlationId);

            // 2. Ensure Rate Card for NOC
            $this->request('post', '/api/v1/rate-card', [
                'section' => 'Certificate',
                'subSection' => 'NOC Application Fee',
                'shift' => 'Morning',
                'generalRate' => $amount,
                'include15PercentRate' => $amount,
                'clientRequestId' => (string) Str::uuid(),
            ], $correlationId);

            // 3. Ensure Bill
            $this->request('post', '/api/v1/billing', [
                'billDate' => $date,
                'jobReportNo' => $noc->token ?: "NOC-JOB-{$noc->id}",
                'banner' => $banner,
                'filmName' => $filmOrWork,
                'shift' => 'Morning',
                'remarks' => "NOC Fee Trx: {$mrNo}",
                'clientRequestId' => (string) Str::uuid(),
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

            // 3. Collection Push
            $colResponse = $this->request('post', '/api/v1/collection', [
                'collectionDate' => $date,
                'banner' => $banner,
                'filmName' => $filmOrWork,
                'mrNo' => $mrNo,
                'collectionAmount' => $amount,
                'clientRequestId' => (string) Str::uuid(),
            ], $correlationId);

            $isSuccess = $colResponse->successful() || $colResponse->status() === 409;

            return [
                'success' => $isSuccess,
                'status' => $colResponse->status(),
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

    /**
     * Push a Rate Card entry to Accounting API (POST /api/v1/rate-card).
     */
    public function pushRateCardToAccounting(\App\Models\Item $item, ?string $shift = null): array
    {
        $correlationId = (string) Str::uuid();
        $section = $item->category ? ($item->category->name_bn ?: $item->category->name_en) : 'General Section';
        $subSection = $item->name_bn ?: ($item->name_en ?: "Item-{$item->id}");

        // If shift not explicitly passed, detect from item's defined shifts or default to 'Morning'
        if (empty($shift)) {
            $itemShift = \App\Models\Shift::where('item_id', $item->id)->first();
            $rawShift = $itemShift ? ($itemShift->name ?: 'Morning') : 'Morning';
            $shift = $this->mapShiftName($rawShift);
        } else {
            $shift = $this->mapShiftName($shift);
        }

        $generalRate = (float) ($item->amount ?: 0);
        $include15PercentRate = $generalRate; // সিস্টেমে একটি প্রাইস থাকায় দুটোই সমান হবে

        // Subrahost expects a standard UUID (Guid).
        // Format: fdc00000-0000-0000-0000-[item_id]
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

    /**
     * Push a Film/Application (Party) record to Accounting API (POST /api/v1/party).
     */
    public function pushFilmApplicationToAccounting(FilmApplication $film): array
    {
        $correlationId = (string) Str::uuid();

        // 1. Resolve Banner (Application's organization/banner name takes top priority, matching MIS table)
        $banner = $film->organization_name ?: ($film->banner_name ?: null);
        $producer = $film->producer ?: Producer::find($film->producer_id);
        if (empty($banner)) {
            $banner = $producer ? ($producer->organization_name ?: $producer->owners_name) : 'General Banner';
        }

        // 2. Film Title
        $filmTitle = $film->film_title ?: 'Untitled Project';

        // 3. Producer Name
        $producerName = $film->applicant_name ?: ($producer ? ($producer->owners_name ?: $producer->organization_name) : 'General Producer');

        // 4. Category and EventType
        // Category holds: 'film', 'drama', 'realityshow', 'docufilm'
        $category = $film->category ?: 'film';
        $eventType = 'Film'; // Subrahost API strictly validates EventType must be 'Film' or 'Advertise'

        // Subrahost strictly parses clientRequestId as a standard GUID (8-4-4-4-12 hex).
        // Format: fdc00000-0000-0000-[producer_id]-[application_id]
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
                'type' => 'Party', // Subrahost live format: 'Party' for dbo.Bill_PartyDetails
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

    /**
     * Push a Producer (Party) record to Accounting API.
     */
    public function pushProducerToAccounting(Producer $producer, ?string $filmTitle = null): array
    {
        $correlationId = (string) Str::uuid();
        $banner = $producer->organization_name ?: ($producer->owners_name ?: 'General Banner');
        $producerName = $producer->owners_name ?: ($producer->organization_name ?: 'General Producer');
        $film = $filmTitle ?: 'General / Registered Project';

        try {
            $payload = [
                'eventType' => 'Film',
                'banner' => $banner,
                'film' => $film,
                'producer' => $producerName,
                'startDate' => $producer->created_at ? $producer->created_at->format('c') : date('c'),
                'openingDebit' => 0.0,
                'openingCredit' => 0.0,
                'type' => 'Party',
                'category' => 'Producer',
                'clientRequestId' => (string) Str::uuid(),
            ];

            $response = $this->request('post', '/api/v1/party', $payload, $correlationId);
            $isSuccess = $response->successful() || $response->status() === 409;

            return [
                'success' => $isSuccess,
                'status' => $response->status(),
                'data' => $response->json(),
                'producerId' => $producer->id,
                'banner' => $banner,
            ];
        } catch (\Throwable $e) {
            Log::error('Producer Accounting push error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'producerId' => $producer->id,
            ];
        }
    }

    /**
     * Push Payment Refund record to Accounting system (Credit Note / Adjustment).
     *
     * @param \App\Models\PaymentRefund $refund
     * @return array
     */
    public function pushRefundToAccounting(\App\Models\PaymentRefund $refund): array
    {
        $correlationId = (string) Str::uuid();
        $filmPackage = \App\Models\FilmPackage::find($refund->payment_id);

        $partyCode = 'PRTY-00001';
        $partyName = 'General Producer';
        $partyPhone = null;
        $banner = 'General Banner';
        $filmTitle = 'General Film';
        $mrNo = ($filmPackage && $filmPackage->bank_payment_id) ? $filmPackage->bank_payment_id : $refund->trn_id;
        $refundDate = $refund->created_at ? $refund->created_at->format('Y-m-d') : date('Y-m-d');
        $refundAmount = (float) $refund->amount;
        $chargeAmount = (float) $refund->charge;

        if ($filmPackage) {
            if ($filmPackage->type === 'booking') {
                $booking = \App\Models\Booking::with(['film', 'producer'])->find($filmPackage->package_id);
                if ($booking) {
                    if ($booking->producer) {
                        $partyCode = "PRTY-" . str_pad($booking->producer->id, 5, '0', STR_PAD_LEFT);
                        $partyName = $booking->producer->owners_name ?: ($booking->producer->organization_name ?: $partyName);
                        $partyPhone = $booking->producer->phone_number;
                    }
                    if ($booking->film) {
                        $banner = $booking->film->banner_name ?: ($booking->film->organization_name ?: $banner);
                        $filmTitle = $booking->film->film_title ?: $filmTitle;
                    }
                }
            } else {
                $package = \App\Models\Package::with(['film', 'producer'])->find($filmPackage->package_id);
                if ($package) {
                    if ($package->producer) {
                        $partyCode = "PRTY-" . str_pad($package->producer->id, 5, '0', STR_PAD_LEFT);
                        $partyName = $package->producer->owners_name ?: ($package->producer->organization_name ?: $partyName);
                        $partyPhone = $package->producer->phone_number;
                    }
                    if ($package->film) {
                        $banner = $package->film->banner_name ?: ($package->film->organization_name ?: $banner);
                        $filmTitle = $package->film->film_title ?: $filmTitle;
                    }
                }
            }
        }

        try {
            // 1. Ensure Party exists in Accounting
            $partyPayload = [
                'partyCode' => $partyCode,
                'name' => $partyName,
                'clientRequestId' => (string) Str::uuid(),
            ];
            if ($partyPhone) {
                $partyPayload['phoneNumber'] = $partyPhone;
            }
            $this->request('post', '/api/v1/party', $partyPayload, $correlationId);

            // 2. Push Refund / Negative Adjustment Collection
            // Posts the refund reversal with original receipt reference
            $refundPayload = [
                'collectionDate' => $refundDate,
                'banner' => $banner,
                'filmName' => $filmTitle,
                'mrNo' => "RFD-{$mrNo}",
                'originalMrNo' => $mrNo,
                'collectionAmount' => -$refundAmount, // Negative amount for accounting reversal
                'refundAmount' => $refundAmount,
                'deductedCharge' => $chargeAmount,
                'remarks' => "Payment Refund for Trx: {$mrNo} (Deducted 10% charge: {$chargeAmount})",
                'clientRequestId' => (string) Str::uuid(),
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
