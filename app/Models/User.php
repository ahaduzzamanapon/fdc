<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'who',
        'employee_type',
        'user_role',
        'staff_class',
        'username',
        'password',
        'name_bn',
        'name_en',
        'father_name',
        'mother_name',
        'gender',
        'religion',
        'dob',
        'nid',
        'mobile_no',
        'email',
        'blood_group',
        'freedom_fighter',
        'marital_status',
        'no_of_child',
        'highest_qualification',
        'div_id',
        'dis_id',
        'upazila_id',
        'village',
        'present_div_id',
        'present_dis_id',
        'present_upazila_id',
        'present_village',
        'picture',
        'signature',
        'note',
        'join_date',
        'department',
        'designation',
        'grade',
        'basic_salary',
        'current_status',
        'group_id',
        'email_verified_at',
        'remember_token',
    ];

    public function designationInfo()
    {
        return $this->belongsTo(Designation::class, 'designation');
    }

    public function departmentInfo()
    {
        return $this->belongsTo(Department::class, 'department');
    }

    public function role()
    {
        return $this->belongsTo(RoleAndPermission::class, 'group_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'div_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'dis_id');
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id');
    }

    public function presentDivision()
    {
        return $this->belongsTo(Division::class, 'present_div_id');
    }

    public function presentDistrict()
    {
        return $this->belongsTo(District::class, 'present_dis_id');
    }

    public function presentUpazila()
    {
        return $this->belongsTo(Upazila::class, 'present_upazila_id');
    }

    public function staffTrainings()
    {
        return $this->hasMany(StaffTraining::class, 'user_id');
    }
}

