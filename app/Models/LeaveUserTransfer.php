<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveUserTransfer extends Model
{
    use HasFactory;
    public $table = 'leave_user_transfers';
    public $fillable = [
        'leave_id',
        'user_id',
    ];
}
	
