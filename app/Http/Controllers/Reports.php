<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\FilmApplication;
use App\Models\DramaApplication;
use App\Models\RealityApplication;
use App\Models\DocufilmApplication;
use Auth;

class Reports extends Controller
{
    public function film_report_index()
    {
        return view('reports.film_report.index');
    }
    public function film_report_show(Request $request)
    {
        $film = FilmApplication::where('producer_id', Auth::guard('producer')->user()->id)->get();
        $html = view('reports.film_report.filmReport', compact('film'))->render();
        return response($html);
    }
    public function drama_report_index()
    {
        return view('reports.drama_report.index');
    }
    public function drama_report_show(Request $request)
    {
        $drama = DramaApplication::where('producer_id', Auth::guard('producer')->user()->id)->get();
        $html = view('reports.drama_report.dramaReport', compact('drama'))->render();
        return response($html);
    }
    public function pramanno_report_index()
    {
        return view('reports.pramanno_report.index');
    }
    public function pramanno_report_show(Request $request)
    {
        $pramanno = DocufilmApplication::where('producer_id', Auth::guard('producer')->user()->id)->get();
        $html = view('reports.pramanno_report.pramannoReport', compact('pramanno'))->render();
        return response($html);
    }
    public function reality_report_index()
    {
        return view('reports.reality_report.index');
    }
    public function reality_report_show(Request $request)
    {
        $reality = RealityApplication::where('producer_id', Auth::guard('producer')->user()->id)->get();
        $html = view('reports.reality_report.realityReport', compact('reality'))->render();
        return response($html);
    }
}
