<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class ItemUnit
 * @package App\Models
 * @version July 7, 2025, 5:01 am UTC
 *
 * @property string $name_bn
 * @property string $name_en
 * @property string $status
 */
class ItemUnit extends Model
{

    public $table = 'itemunits';
    



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
