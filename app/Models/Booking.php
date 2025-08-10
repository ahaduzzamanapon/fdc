<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['producer_id','film_id','book_id','status','total_price'];

    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function film()
    {
        return $this->belongsTo(FilmApplication::class, 'film_id');
    }

    public function producer()
    {
        return $this->belongsTo(Producer::class, 'producer_id');
    }
}
