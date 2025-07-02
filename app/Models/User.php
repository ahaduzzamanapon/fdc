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
        'dis_id',
        'upazila_id',
        'present_add',
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


}

