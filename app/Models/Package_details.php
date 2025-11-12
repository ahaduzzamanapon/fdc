<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Package
 * @package App\Models
 * @version July 24, 2025, 5:01 am UTC
 *
 * @property string $name
 * @property integer $amount
 * @property string $type
 * @property string $status
 * @property string $description
 */
class Package_details extends Model
{

    public $table = 'packages_details';




    public $fillable = [
        'package_id',
        'item_id',
        'item_amt',
        'request_days',
        'request_total_amt',
        'app_days',
        'app_total_amt',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'package_id' => 'integer',
        'item_id' => 'integer',
        'item_amt' => 'integer',
        'request_days' => 'integer',
        'request_total_amt' => 'integer',
        'app_days' => 'integer',
        'app_total_amt' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
