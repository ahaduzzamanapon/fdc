<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Shift
 * @package App\Models
 * @version July 30, 2025, 5:45 am UTC
 *
 * @property string $name
 * @property string $category_id
 * @property string $item_id
 * @property string $start_time
 * @property string $end_time
 * @property string $description
 */
class Shift extends Model
{

    public $table = 'shifts';
    



    public $fillable = [
        'name',
        'category_id',
        'item_id',
        'start_time',
        'end_time',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'category_id' => 'string',
        'item_id' => 'string',
        'start_time' => 'string',
        'end_time' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'category_id' => 'required',
        'item_id' => 'required',
        'start_time' => 'required',
        'end_time' => 'required'
    ];

    
}
