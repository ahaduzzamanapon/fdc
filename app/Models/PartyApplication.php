<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class FilmApplication
 * @package App\Models
 * @version July 24, 2025, 9:52 am UTC
 *
 * @property string $film_title
 * @property string $applicant_nam
 * @property string $father_nam
 * @property string $mother_nam
 * @property string $permanent_address
 * @property string $present_address
 * @property string $nid_number
 * @property string $phone_number
 * @property string $email
 * @property string $organization_name
 * @property string $organization_address
 * @property string $organization_phone
 * @property string $organization_email
 * @property string $bank_account_info
 * @property string $film_serial_no
 * @property string $production_start_date
 * @property string $budget_amount
 * @property string $service_type
 * @property string $nominee_name
 * @property string $nominee_relation
 * @property string $film_duration
 * @property string $set_design
 * @property string $equipment_rental
 * @property string $editing
 * @property string $color_grading
 * @property string $vfx
 * @property string $digital_camera
 * @property string $digital_lab
 * @property string $approx_cost_general
 * @property string $approx_cost_animation
 * @property string $approx_cost_shortfilm
 * @property string $approx_cost_others
 * @property string $film_type
 * @property string $org_type
 * @property string $banner_name
 * @property string $freedom_film_info
 * @property string $previous_films_info
 * @property string $board_member_status
 * @property string $director_name
 * @property string $director_nid
 * @property string $cameraman_name
 * @property string $main_cast
 * @property string $foreign_participation
 * @property string $script_writer_name
 */
class PartyApplication extends Model
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
