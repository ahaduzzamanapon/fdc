<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Noc
 * @package App\Models
 * @version October 28, 2025, 6:56 am UTC
 *
 * @property integer $request_id
 * @property integer $action_by
 * @property integer $action_role_id
 * @property string $action
 * @property string $remarks
 */
class Noc extends Model
{

    public $table = 'nocs';

    public $fillable = [
        'name',
        'token',
        'status',
        'current_role_id',
        'producer',
        'organization',
        'type',
        'cen_certificate_no',
        'cen_certificate_date',
        'publish_date',
        'place',
        'full_name',
        'designation',
        'mobile_no',
        'email',
        'address',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'token' => 'string',
        'status' => 'string',
        'current_role_id' => 'integer',
        'producer' => 'string',
        'organization' => 'string',
        'type' => 'string',
        'cen_certificate_no' => 'string',
        'cen_certificate_date' => 'date',
        'publish_date' => 'date',
        'place' => 'string',
        'full_name' => 'string',
        'designation' => 'string',
        'mobile_no' => 'string',
        'email' => 'string',
        'address' => 'string',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'producer' => 'required',
        'organization' => 'required',
        'type' => 'required',
        'cen_certificate_no' => 'required',
        'cen_certificate_date' => 'required',
        'publish_date' => 'required',

        'full_name' => 'required',
        'designation' => 'required',
        'mobile_no' => 'required',
        'email' => 'required',
        'address' => 'required',
    ];


}
