<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id', 'catagori', 'item_id','shift_id',
        'amount', 'start_date', 'end_date',
        'total_day', 'total_amount'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
