<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NocSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'charge',
        'total',
        'updated_by',
    ];

    protected $casts = [
        'id' => 'integer',
        'amount' => 'decimal:2',
        'charge' => 'decimal:2',
        'total' => 'decimal:2',
        'updated_by' => 'integer',
    ];
}
