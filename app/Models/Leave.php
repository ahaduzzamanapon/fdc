<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Leave
 * @package App\Models
 * @version June 26, 2025, 8:43 am UTC
 *
 * @property string $from_date
 * @property string $to_date
 * @property integer $total_day
 * @property string $approved_from_date
 * @property string $approved_to_date
 * @property integer $approved_total_day
 * @property string $remark
 * @property string $status
 * @property string $approver_remark
 */
class Leave extends Model
{

    public $table = 'leaves';
    public $fillable = [
        'employee_id',
        'dpt_id',
        'from_date',
        'to_date',
        'total_day',
        'approved_from_date',
        'approved_to_date',
        'approved_total_day',
        'remark',
        'status',
        'leave_type',
        'dpt_head_id',
        'approver_id',
        'approver_remark'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'from_date' => 'date',
        'to_date' => 'date',
        'total_day' => 'integer',
        'approved_from_date' => 'date',
        'approved_to_date' => 'date',
        'approved_total_day' => 'integer',
        'remark' => 'string',
        'status' => 'string',
        'leave_type' => 'string',
        'approver_id' => 'integer',
        'approver_remark' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
