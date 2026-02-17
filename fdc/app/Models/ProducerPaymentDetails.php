<?php

namespace App\Models;

use Eloquent as Model;

class ProducerPaymentDetails extends Model
{
    public $table = 'producer_payment_details';
    public $fillable = [
        'producer_id',
        'amount',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'producer_id',
        'amount',
        'type'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

}
