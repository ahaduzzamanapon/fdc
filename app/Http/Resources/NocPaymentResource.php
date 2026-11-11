<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NocPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $formattedNocId = sprintf("NOC-%05d", $this->id);

        return [
            'nocId' => $formattedNocId,
            'mrNo' => $this->trx_id ?: ($this->token ?: $formattedNocId),
            'collectionDate' => $this->updated_at ? $this->updated_at->format('Y-m-d') : ($this->created_at ? $this->created_at->format('Y-m-d') : date('Y-m-d')),
            'collectionAmount' => (float) ($this->amount ?: 0),
            'status' => $this->status,
            'serviceName' => 'NOC Application Fee',
            'applicant' => [
                'fullName' => $this->full_name,
                'designation' => $this->designation,
                'producer' => $this->producer,
                'organization' => $this->organization,
                'mobile' => $this->mobile_no,
                'email' => $this->email,
                'address' => $this->address,
            ],
            'nocDetails' => [
                'filmOrWorkName' => $this->name,
                'type' => $this->type,
                'censorCertificateNo' => $this->cen_certificate_no,
                'censorCertificateDate' => $this->cen_certificate_date ? (is_string($this->cen_certificate_date) ? $this->cen_certificate_date : $this->cen_certificate_date->format('Y-m-d')) : null,
                'publishDate' => $this->publish_date,
                'place' => $this->place,
            ],
            'auditTrail' => [
                'noc_code' => $formattedNocId,
                'token' => $this->token,
                'trx_id' => $this->trx_id,
                'paidAt' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
            ]
        ];
    }
}
