<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Reports extends Controller
{
    public function film_report()
    {
        return view('reports.film_report.index');
    }
    public function drama_report()
    {
        return view('reports.drama_report.index');
    }
    public function pramanno_report()
    {
        return view('reports.pramanno_report.index');
    }
    public function reality_report()
    {
        return view('reports.reality_report.index');
    }
}
