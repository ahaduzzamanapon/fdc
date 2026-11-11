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
                if ($booking->film) {
                    $banner = $booking->film->banner_name ?: ($booking->film->organization_name ?: $banner);
                    $filmTitle = $booking->film->film_title ?: $filmTitle;
                    $producerName = $booking->film->applicant_name ?: $producerName;
                }
                if ($booking->producer) {
                    $producerName = $booking->producer->owners_name ?: ($booking->producer->organization_name ?: $producerName);
                    $producerPhone = $booking->producer->phone_number;
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
                if ($package->film) {
                    $banner = $package->film->banner_name ?: ($package->film->organization_name ?: $banner);
                    $filmTitle = $package->film->film_title ?: $filmTitle;
                    $producerName = $package->film->applicant_name ?: $producerName;
                }
                if ($package->producer) {
                    $producerName = $package->producer->owners_name ?: ($package->producer->organization_name ?: $producerName);
                    $producerPhone = $package->producer->phone_number;
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

            // 2. Ensure Bill
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
        $date = $noc->updated_at ? $noc->updated_at->format('Y-m-d') : ($noc->created_at ? $noc->created_at->format('Y-m-d') : date('Y-m-d'));
        $banner = $noc->organization ?: ($noc->producer ?: 'General Organization');
        $filmOrWork = $noc->name ?: 'NOC Certificate Application';
        $producer = $noc->producer ?: ($noc->full_name ?: 'Applicant');
        $amount = (float) ($noc->amount ?: 0);

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

            // 2. Ensure Bill
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
}
