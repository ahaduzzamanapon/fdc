<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Producer
 * @package App\Models
 * @version July 2, 2025, 12:12 pm UTC
 *
 * @property string $organization_name
 * @property string $address
 * @property string $phone_number
 * @property string $email
 * @property string $bank_name
 * @property string $bank_branch
 * @property string $bank_account_number
 * @property string $bank_attachment
 * @property string $tin_number
 * @property string $trade_license
 * @property string $vat_registration_number
 * @property string $nominee_name
 * @property string $nominee_relation
 * @property string $nominee_nid
 * @property string $nominee_photo
 * @property string $partnership_agreement
 * @property string $ltd_company_agreement
 * @property string $somobay_agreement
 * @property string $other_attachment
 * @property string $trade_license_validity_date
 * @property string $trade_license_attachment
 * @property string $vat_attachment
 * @property string $tin_attachment
 * @property string $status
 */
class Producer extends Model
{

    public $table = 'producers';
    



    public $fillable = [
        'organization_name',
        'address',
        'phone_number',
        'email',
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
