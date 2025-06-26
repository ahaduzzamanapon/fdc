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
        'name_bn',
        'name_en',
        'gender',
        'religion',
        'father_name',
        'mother_name',
        'dob',
        'nid',
        'mobile_no',
        'email',
        'blood_group',
        'marital_status',
        'no_of_child',
        'highest_qualification',
        'dis_id',
        'picture',
        'signature',
        'present_add',
        'note',
        'employee_type',
        'join_date',
        'grade',
        'designation',
        'basic_salary',
        'current_status',
        'username',
        'password',
        'group_id',
        'email_verified_at',
        'remember_token',
    ];

  
}

