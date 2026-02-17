<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class ItemCategory
 * @package App\Models
 * @version July 7, 2025, 5:02 am UTC
 *
 * @property string $name_bn
 * @property string $name_en
 * @property string $status
 */
class ItemCategory extends Model
{

    public $table = 'itemcategorys';
    



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
