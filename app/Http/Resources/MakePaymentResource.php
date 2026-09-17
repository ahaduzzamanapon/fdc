<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'trn_id' => $this->trn_id,
            'TrxID'  => $this->TrxID,
            'name'   => $this->name,
            'type'   => $this->type,
            'amount' => $this->amount,
            'status' => $this->status,
        ];
    }
}
