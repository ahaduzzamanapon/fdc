<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Department
 * @package App\Models
 * @version July 1, 2025, 12:27 pm UTC
 *
 * @property string $name_bn
 * @property string $name_en
 * @property string $status
 */
class Department extends Model
{

    public $table = 'departments';
    



    public $fillable = [
        'name_bn',
        'name_en',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name_bn' => 'string',
        'name_en' => 'string',
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
