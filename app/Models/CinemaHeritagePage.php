<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaHeritagePage extends Model
{
    use HasFactory;

    protected $table = 'cinema_heritage_pages';

    protected $fillable = [
        'slug',
        'title',
        'banner_subtitle',
        'main_description',
        'banner_image',
    ];

    public function items()
    {
        return $this->hasMany(CinemaHeritageItem::class, 'page_id')->orderBy('sort_order', 'asc');
    }
}
