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
class Package extends Model
{

    public $table = 'packages';




    public $fillable = [
        'name',
        'desk_id',
        'film_type',
        'film_id',
        'service_type',
        'producer_id',
        'package_type',
        'request_amt',
        'amount',
        'type',
        'status',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'desk_id' => 'integer',
        'film_type' => 'string',
        'film_id' => 'integer',
        'service_type' => 'string',
        'producer_id' => 'integer',
        'package_type' => 'string',
        'request_amt' => 'integer',
        'amount' => 'integer',
        'type' => 'string',
        'status' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
