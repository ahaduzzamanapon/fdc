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
class FilmApplication extends Model
{

    public $table = 'filmapplications';
    



    public $fillable = [
        'producer_id',
        'desk',
        'state',
        'balance',
        'film_title',
        'applicant_name',
        'father_name',
        'mother_name',
        'permanent_address',
        'present_address',
        'nid_number',
        'phone_number',
        'email',
        'organization_name',
        'organization_address',
        'organization_phone',
        'organization_email',
        'bank_account_info',
        'film_serial_no',
        'production_start_date',
        'budget_amount',
        'service_type',
        'nominee_name',
        'nominee_relation',
        'film_duration',
        'equipment_rental',
        'editing',
        'color_grading',
        'vfx',
        'digital_camera',
        'digital_lab',
        'film_type',
        'org_type',
        'banner_name',
        'freedom_film_info',
        'previous_films_info',
        'board_member_status',
        'director_name',
        'director_nid',
        'cameraman_name',
        'main_cast',
        'foreign_participation',
        'script_writer_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'film_title' => 'string',
        'applicant_nam' => 'string',
        'father_nam' => 'string',
        'mother_nam' => 'string',
        'permanent_address' => 'string',
        'present_address' => 'string',
        'nid_number' => 'string',
        'phone_number' => 'string',
        'email' => 'string',
        'organization_name' => 'string',
        'organization_address' => 'string',
        'organization_phone' => 'string',
        'organization_email' => 'string',
        'bank_account_info' => 'string',
        'film_serial_no' => 'string',
        'production_start_date' => 'string',
        'budget_amount' => 'string',
        'service_type' => 'string',
        'nominee_name' => 'string',
        'nominee_relation' => 'string',
        'film_duration' => 'string',
        'set_design' => 'string',
        'equipment_rental' => 'string',
        'editing' => 'string',
        'color_grading' => 'string',
        'vfx' => 'string',
        'digital_camera' => 'string',
        'digital_lab' => 'string',
        'approx_cost_general' => 'string',
        'approx_cost_animation' => 'string',
        'approx_cost_shortfilm' => 'string',
        'approx_cost_others' => 'string',
        'film_type' => 'string',
        'org_type' => 'string',
        'banner_name' => 'string',
        'freedom_film_info' => 'string',
        'previous_films_info' => 'string',
        'board_member_status' => 'string',
        'director_name' => 'string',
        'director_nid' => 'string',
        'cameraman_name' => 'string',
        'main_cast' => 'string',
        'foreign_participation' => 'string',
        'script_writer_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
