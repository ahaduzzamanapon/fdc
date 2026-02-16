<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Division
 * @package App\Models
 * @version July 13, 2025, 8:52 am UTC
 *
 * @property string $name_bn
 * @property string $name_en
 * @property string $status
 */
class ItemDepartment extends Model
{

    public $table = 'item_departments';




    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
