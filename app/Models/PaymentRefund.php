<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRefund extends Model
{
    use HasFactory;

    public $table = 'payment_refunds';
    public $fillable = [
        'payment_id',
        'trn_id',
        'amount',
        'charge',
        'type',
        'status',
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
        'payment_id' => 'integer',
        'trn_id' => 'string',
        'amount' => 'string',
        'charge' => 'string',
        'type' => 'string',
        'status' => 'string',
        'created_by' => 'string',
        'updated_by' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'payment_id' => 'required',
        'trn_id' => 'required',
        'amount' => 'required',
        'charge' => 'required',
        'type' => 'required',
        'status' => 'required',
        'created_by' => 'required',
        'updated_by' => 'required'
    ];
}
