<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class ApprovalRequests
 * @package App\Models
 * @version October 28, 2025, 6:51 am UTC
 *
 * @property integer $flow_id
 * @property string $request_type
 * @property integer $current_role_id
 * @property integer $next_role_id
 * @property string $status
 * @property string $request_data
 * @property integer $created_by
 */
class ApprovalRequests extends Model
{

    public $table = 'approval_requests';




    public $fillable = [
        'flow_id',
        'request_type',
        'prev_role_id',
        'current_role_id',
        'next_role_id',
        'status',
        'request_data',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'flow_id' => 'integer',
        'request_type' => 'string',
        'prev_role_id' => 'integer',
        'current_role_id' => 'integer',
        'next_role_id' => 'integer',
        'status' => 'string',
        'request_data' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'flow_id' => 'required',
        'request_type' => 'required',
        'current_role_id' => 'required',
    ];


}
