<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveResource extends JsonResource
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
            'employee_id' => $this->employee_id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'total_day' => $this->total_day,
            'approved_from_date' => $this->approved_from_date,
            'approved_to_date' => $this->approved_to_date,
            'approved_total_day' => $this->approved_total_day,
            'remark' => $this->remark,
            'status' => $this->status,
            'approver_id' => $this->approver_id,
            'approver_remark' => $this->approver_remark,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
