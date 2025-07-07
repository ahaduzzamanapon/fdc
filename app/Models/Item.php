<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Item
 * @package App\Models
 * @version July 7, 2025, 5:12 am UTC
 *
 * @property string $name_bn
 * @property string $name_en
 * @property integer $cat_id
 * @property integer $unit_id
 * @property integer $duration
 * @property number $max_times
 * @property number $amount
 * @property string $description
 */
class Item extends Model
{

    public $table = 'items';
    



    public $fillable = [
        'name_bn',
        'name_en',
        'cat_id',
        'unit_id',
        'duration',
        'max_times',
        'amount',
        'description'
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
        'cat_id' => 'integer',
        'unit_id' => 'integer',
        'duration' => 'integer',
        'max_times' => 'decimal:2',
        'amount' => 'decimal:2',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
