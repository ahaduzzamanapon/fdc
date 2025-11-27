<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('font_end.body');
    }
    public function about_us()
    {
        return view('font_end.about_us');
    }

    public function films_released_by_decade($decade)
    {
        return view('font_end.films_released_by_decade', compact('decade'));
    }

    public function rate_card(){
        return view('font_end.rate_card');
    }
}
