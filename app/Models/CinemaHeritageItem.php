<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaHeritageItem extends Model
{
    use HasFactory;

    protected $table = 'cinema_heritage_items';

    protected $fillable = [
        'page_id',
        'title',
        'sub_title',
        'description',
        'image',
        'sort_order',
    ];

    public function page()
    {
        return $this->belongsTo(CinemaHeritagePage::class, 'page_id');
    }
}
