<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecadeFilmList extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'film_name',
        'producer_name',
        'director_name',
        'acting',
        'type',
        'release_date',
        'achivements',
    ];
}
