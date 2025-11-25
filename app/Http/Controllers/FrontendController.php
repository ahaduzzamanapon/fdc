<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function about_us()
    {
        return view('font_end.about_us');
    }
}
