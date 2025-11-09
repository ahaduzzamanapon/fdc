<?php

namespace App\Models;

use Eloquent as Model;

class ProducerBalance extends Model
{
    public $table = 'producer_balance';
    public $fillable = [
        'producer_id',
        'total_in',
        'total_out',
        'current_balance'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'producer_id',
        'total_in',
        'total_out',
        'current_balance'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

}
