<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Producer extends Authenticatable
{

    public $table = 'producers';
    



    public $fillable = [
        'who',
        'username',
        'organization_name',
        'address',
        'phone_number',
        'email',
        'password',
        'bank_name',
        'bank_branch',
        'bank_account_number',
        'bank_attachment',
        'tin_number',
        'trade_license',
        'vat_registration_number',
        'nominee_name',
        'nominee_relation',
        'nominee_nid',
        'nominee_photo',
        'partnership_agreement',
        'ltd_company_agreement',
        'somobay_agreement',
        'other_attachment',
        'trade_license_validity_date',
        'trade_license_attachment',
        'vat_attachment',
        'tin_attachment',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'organization_name' => 'string',
        'address' => 'string',
        'phone_number' => 'string',
        'email' => 'string',
        'bank_name' => 'string',
        'bank_branch' => 'string',
        'bank_account_number' => 'string',
        'bank_attachment' => 'string',
        'tin_number' => 'string',
        'trade_license' => 'string',
        'vat_registration_number' => 'string',
        'nominee_name' => 'string',
        'nominee_relation' => 'string',
        'nominee_nid' => 'string',
        'nominee_photo' => 'string',
        'partnership_agreement' => 'string',
        'ltd_company_agreement' => 'string',
        'somobay_agreement' => 'string',
        'other_attachment' => 'string',
        'trade_license_validity_date' => 'date',
        'trade_license_attachment' => 'string',
        'vat_attachment' => 'string',
        'tin_attachment' => 'string',
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
