<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsOfficer extends Model
{
    use HasFactory;

    protected $table = 'about_us_officers';

    protected $fillable = [
        'name',
        'designation',
        'image',
        'sort_order',
    ];
}
