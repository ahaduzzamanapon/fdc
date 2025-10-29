<?php

namespace App\Models;

use Eloquent as Model;


/**
 * Class ApprovalFlowMaster
 * @package App\Models
 * @version October 28, 2025, 6:23 am UTC
 *
 * @property string $name
 * @property string $status
 * @property string $description
 */
class ApprovalFlowMaster extends Model
{

    public $table = 'approval_flow_master';




    public $fillable = [
        'name',
        'status',
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
        'status' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    public function steps()
    {
        return $this->hasMany(ApprovalFlowStep::class, 'flow_id');
    }


}
