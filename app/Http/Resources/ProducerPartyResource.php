<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProducerPartyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'eventType' => 'Film',
            'banner' => $this->organization_name,
            'film' => $this->film_title ?? ($this->latestFilmApplication->film_title ?? null),
            'producer' => $this->owners_name,
            'type' => 'Party',
            'category' => 'Producer',
            'organization_name' => $this->organization_name,
            'owners_name' => $this->owners_name,
            'owners_nid' => $this->owners_nid,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => $this->address,
            'bank_name' => $this->bank_name,
            'bank_branch' => $this->bank_branch,
            'bank_account_number' => $this->bank_account_number,
            'tin_number' => $this->tin_number,
            'trade_license' => $this->trade_license,
            'vat_registration_number' => $this->vat_registration_number,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
