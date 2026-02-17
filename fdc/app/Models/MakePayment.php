<?php

namespace App\Models;

use Eloquent as Model;

class MakePayment extends Model
{
    public $table = 'film_packages';
    public $fillable = [
        'amount',
        'trn_id',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount',
        'trn_id',
        'status'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

}
