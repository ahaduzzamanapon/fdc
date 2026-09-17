<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class EmployeePromotion
 * @package App\Models
 */
class EmployeePromotion extends Model
{
    public $table = 'employee_promotions';

    public $fillable = [
        'user_id',
        'change_type',
        'department_id',
        'designation_id',
        'staff_class',
        'grade',
        'basic_salary',
        'effect_month',
        'remarks',
        'created_by',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'change_type' => 'string',
        'department_id' => 'integer',
        'designation_id' => 'integer',
        'staff_class' => 'string',
        'grade' => 'string',
        'basic_salary' => 'float',
        'effect_month' => 'string',
        'remarks' => 'string',
        'created_by' => 'integer'
    ];

    /**
     * User relation
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Department relation
     */
    public function departmentInfo()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Designation relation
     */
    public function designationInfo()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    /**
     * Creator relation
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
