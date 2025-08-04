<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmPackage extends Model
{
    use HasFactory;
     public $fillable = [
        'film_id',
        'package_id',
        'amount',
        'trn_id',
        'status'
    ];
    
}
