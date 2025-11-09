<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class ApprovalFlowSteps
 * @package App\Models
 * @version October 28, 2025, 6:37 am UTC
 *
 * @property integer $flow_id
 * @property integer $from_role_id
 * @property integer $to_role_id
 * @property integer $step_order
 */
class ApprovalFlowSteps extends Model
{

    public $table = 'approval_flow_steps';




    public $fillable = [
        'flow_id',
        'from_role_id',
        'to_role_id',
        'step_order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'flow_id' => 'integer',
        'from_role_id' => 'integer',
        'to_role_id' => 'integer',
        'step_order' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'flow_id' => 'required',
        'from_role_id' => 'required',
        'to_role_id' => 'required',
        'step_order' => 'required'
    ];


}
