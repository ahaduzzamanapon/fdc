<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalRequestsResource extends JsonResource
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
            'flow_id' => $this->flow_id,
            'request_type' => $this->request_type,
            'current_role_id' => $this->current_role_id,
            'next_role_id' => $this->next_role_id,
            'status' => $this->status,
            'request_data' => $this->request_data,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
