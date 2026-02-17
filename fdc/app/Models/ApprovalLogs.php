<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class ApprovalLogs
 * @package App\Models
 * @version October 28, 2025, 6:56 am UTC
 *
 * @property integer $request_id
 * @property integer $action_by
 * @property integer $action_role_id
 * @property string $action
 * @property string $remarks
 */
class ApprovalLogs extends Model
{

    public $table = 'approval_logs';




    public $fillable = [
        'request_id',
        'request_type',
        'flow_id',
        'action_by',
        'action_role_id',
        'next_role_id',
        'status',
        'remarks',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'request_id' => 'integer',
        'request_type' => 'string',
        'flow_id' => 'integer',
        'action_by' => 'integer',
        'action_role_id' => 'integer',
        'next_role_id' => 'integer',
        'status' => 'string',
        'remarks' => 'string',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'request_id' => 'required',
        'request_type' => 'required',
        'flow_id' => 'required',
        'action_by' => 'required',
        'action_role_id' => 'required'
    ];


}
