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
        $banner = null;
        $filmTitle = null;
        $producerName = null;
        $partyId = null;

        if ($this->type === 'booking') {
            $booking = Booking::with(['film', 'producer'])->find($this->package_id);
            if ($booking) {
                $partyId = $booking->producer_id;
                $producerName = $booking->producer ? $booking->producer->owners_name : null;
                $banner = $booking->film ? ($booking->film->banner_name ?: $booking->film->organization_name) : ($booking->producer ? $booking->producer->organization_name : null);
                $filmTitle = $booking->film ? $booking->film->film_title : null;
            }
        } else {
            $package = Package::with(['film', 'producer'])->find($this->package_id);
            if ($package) {
                $partyId = $package->producer_id;
                $producerName = $package->producer ? $package->producer->owners_name : null;
                $banner = $package->film ? ($package->film->banner_name ?: $package->film->organization_name) : ($package->producer ? $package->producer->organization_name : null);
                $filmTitle = $package->film ? $package->film->film_title : null;
            }
        }

        return [
            'id'             => $this->id,
            'trn_id'         => $this->trn_id,
            'TrxID'          => $this->TrxID,
            'party_id'       => $partyId,
            'producer_name'  => $producerName,
            'banner'         => $banner ?: $this->name,
            'film_name'      => $filmTitle,
            'name'           => $this->name,
            'type'           => $this->type,
            'amount'         => (float) $this->amount,
            'status'         => $this->status,
            'paid_at'        => $this->paid_at,
            'created_at'     => $this->created_at,
        ];
    }
}

