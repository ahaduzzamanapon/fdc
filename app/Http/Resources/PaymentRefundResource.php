<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\FilmPackage;
use App\Models\Booking;
use App\Models\Package;

class PaymentRefundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $payment = FilmPackage::find($this->payment_id);
        
        $partyId = null;
        $applicationId = null;
        $banner = 'General Banner';
        $filmTitle = 'General Film';
        $producerName = 'Producer';
        $producerPhone = null;

        if ($payment) {
            $applicationId = $payment->film_id ? "APP-" . str_pad($payment->film_id, 5, '0', STR_PAD_LEFT) : null;
            if ($payment->type === 'booking') {
                $booking = Booking::with(['film', 'producer'])->find($payment->package_id);
                if ($booking) {
                    $partyId = $booking->producer_id ? "PRTY-" . str_pad($booking->producer_id, 5, '0', STR_PAD_LEFT) : null;
                    if ($booking->film) {
                        $applicationId = "APP-" . str_pad($booking->film->id, 5, '0', STR_PAD_LEFT);
                        $banner = $booking->film->banner_name ?: ($booking->film->organization_name ?: $banner);
                        $filmTitle = $booking->film->film_title ?: $filmTitle;
                        $producerName = $booking->film->applicant_name ?: $producerName;
                    }
                    if ($booking->producer) {
                        $partyId = "PRTY-" . str_pad($booking->producer->id, 5, '0', STR_PAD_LEFT);
                        $producerName = $booking->producer->owners_name ?: ($booking->producer->organization_name ?: $producerName);
                        $producerPhone = $booking->producer->phone_number;
                    }
                }
            } else {
                $package = Package::with(['film', 'producer'])->find($payment->package_id);
                if ($package) {
                    $partyId = $package->producer_id ? "PRTY-" . str_pad($package->producer_id, 5, '0', STR_PAD_LEFT) : null;
                    if ($package->film) {
                        $applicationId = "APP-" . str_pad($package->film->id, 5, '0', STR_PAD_LEFT);
                        $banner = $package->film->banner_name ?: ($package->film->organization_name ?: $banner);
                        $filmTitle = $package->film->film_title ?: $filmTitle;
                        $producerName = $package->film->applicant_name ?: $producerName;
                    }
                    if ($package->producer) {
                        $partyId = "PRTY-" . str_pad($package->producer->id, 5, '0', STR_PAD_LEFT);
                        $producerName = $package->producer->owners_name ?: ($package->producer->organization_name ?: $producerName);
                        $producerPhone = $package->producer->phone_number;
                    }
                }
            }
        }

        $grossAmount = (float) ($payment ? $payment->amount : ((float)$this->amount + (float)$this->charge));
        $refundAmount = (float) $this->amount;
        $serviceCharge = (float) $this->charge;

        return [
            'refundId' => 'RFD-' . str_pad($this->id, 5, '0', STR_PAD_LEFT),
            'originalTrnId' => $this->trn_id,
            'mrNo' => ($payment && $payment->bank_payment_id) ? $payment->bank_payment_id : $this->trn_id,
            'partyId' => $partyId,
            'applicationId' => $applicationId,
            'banner' => $banner,
            'filmName' => $filmTitle,
            'producer' => $producerName,
            'producerPhone' => $producerPhone,
            'paymentType' => $this->type,
            'grossAmount' => $grossAmount,
            'deductedCharge' => $serviceCharge,
            'netRefundAmount' => $refundAmount,
            'status' => $this->status, // pending, approved, refunded, etc.
            'refundDate' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
            'auditTrail' => [
                'refund_ref' => 'RFD-' . str_pad($this->id, 5, '0', STR_PAD_LEFT),
                'trn_id' => $this->trn_id,
                'payment_id' => $this->payment_id,
                'requestedAt' => $this->created_at ? $this->created_at->toDateTimeString() : null,
                'updatedAt' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
            ]
        ];
    }
}
