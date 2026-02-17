<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class LeaveType
 * @package App\Models
 * @version July 2, 2025, 9:43 am UTC
 *
 * @property string $name_bn
 * @property string $name_en
 * @property string $type
 * @property integer $day
 * @property string $status
 */
class LeaveType extends Model
{

    public $table = 'leave_types';




    public $fillable = [
        'name_bn',
        'name_en',
        'type',
        'day',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name_bn' => 'string',
        'name_en' => 'string',
        'type' => 'string',
        'day' => 'integer',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
