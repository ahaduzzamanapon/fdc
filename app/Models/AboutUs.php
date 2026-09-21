<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'about_uses';

    protected $fillable = [
        'banner_title',
        'banner_subtitle',
        'main_title',
        'main_description',
        'main_image',
        'team_title',
    ];
}
