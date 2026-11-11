<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Booking;
use App\Models\Package;

class MakePaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $banner = 'General Banner';
        $filmTitle = 'General Film';
        $producerName = 'Producer';
        $producerPhone = null;
        $jobReportNo = $this->trn_id ?: "JOB-{$this->id}";
        $lineItems = [];

        if ($this->type === 'booking') {
            $booking = Booking::with(['details.item', 'details.shift', 'film', 'producer'])->find($this->package_id);
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
                            'shift' => $shiftName,
                            'rateType' => 'GeneralRate',
                            'rate' => (float) ($d->amount ?: 0),
                            'unit' => 'Shift',
                            'quantity' => (float) ($d->total_day ?: 1),
                        ];
                    }
                }
            }
        } else {
            $package = Package::with(['details.item', 'film', 'producer'])->find($this->package_id);
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
                            'shift' => 'Morning',
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
                'subSection' => $this->name ?: 'Booking Package Fee',
                'shift' => 'Morning',
                'rateType' => 'GeneralRate',
                'rate' => (float) $this->amount,
                'unit' => 'Shift',
                'quantity' => 1,
            ];
        }

        $mrNo = $this->TrxID ?: ($this->trn_id ?: "MR-{$this->id}");
        $date = $this->paid_at ? date('Y-m-d', strtotime($this->paid_at)) : date('Y-m-d', strtotime($this->created_at));

        return [
            // Standard Accounting fields (matching BFDC Doc)
            'mrNo' => $mrNo,
            'collectionDate' => $date,
            'collectionAmount' => (float) $this->amount,
            'status' => $this->status,
            'banner' => $banner,
            'filmName' => $filmTitle,
            'producer' => $producerName,
            'jobReportNo' => $jobReportNo,
            'billDate' => $date,
            'lineItems' => $lineItems,

            // Safe extra audit fields
            'auditTrail' => [
                'trn_id' => $this->trn_id,
                'TrxID' => $this->TrxID,
                'package_id' => $this->package_id,
                'type' => $this->type,
                'producerContact' => $producerPhone,
                'paidAt' => $this->paid_at,
            ]
        ];
    }
}
