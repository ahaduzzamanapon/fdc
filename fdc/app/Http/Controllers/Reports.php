<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\FilmApplication;
use App\Models\DramaApplication;
use App\Models\RealityApplication;
use App\Models\DocufilmApplication;
use App\Exports\ViewExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use DB;

class Reports extends Controller
{
    public function film_report_index()
    {
        return view('reports.film_report.index');
    }
    public function film_report_show(Request $request)
    {
        $producerId = Auth::guard('producer')->user()->id;
        $film = FilmApplication::query()
        ->where('producer_id', $producerId)
        ->when(!empty($request->from_date) && !empty($request->to_date), function ($query) use ($request) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        })
        ->when(!empty($request->status), function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->get();
        $html = view('reports.film_report.filmReport', compact('film'))->render();
        return response($html);
    }
    public function drama_report_index()
    {
        return view('reports.drama_report.index');
    }
    public function drama_report_show(Request $request)
    {
        $producerId = Auth::guard('producer')->user()->id;
        $drama = DramaApplication::query()
        ->where('producer_id', $producerId)
        ->when(!empty($request->from_date) && !empty($request->to_date), function ($query) use ($request) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        })
        ->when(!empty($request->status), function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->get();
        $html = view('reports.drama_report.dramaReport', compact('drama'))->render();
        return response($html);
    }
    public function pramanno_report_index()
    {
        return view('reports.pramanno_report.index');
    }
    public function pramanno_report_show(Request $request)
    {
        $producerId = Auth::guard('producer')->user()->id;
        $pramanno = DocufilmApplication::query()
        ->where('producer_id', $producerId)
        ->when(!empty($request->from_date) && !empty($request->to_date), function ($query) use ($request) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        })
        ->when(!empty($request->status), function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->get();
        $html = view('reports.pramanno_report.pramannoReport', compact('pramanno'))->render();
        return response($html);
    }
    public function reality_report_index()
    {
        return view('reports.reality_report.index');
    }
    public function reality_report_show(Request $request)
    {

        $producerId = Auth::guard('producer')->user()->id;
        $reality = RealityApplication::query()
        ->where('producer_id', $producerId)
        ->when(!empty($request->from_date) && !empty($request->to_date), function ($query) use ($request) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        })
        ->when(!empty($request->status), function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->get();
        $html = view('reports.reality_report.realityReport', compact('reality'))->render();
        return response($html);
    }

    /// export excel report

    public function exportReport(Request $request, $type )
    {
        $producerId = Auth::guard('producer')->user()->id;
        switch ($type) {
            case 'film':
                $query = FilmApplication::query();
                $view = 'reports.film_report.filmReport';
                $filename = 'film_report.xlsx';
                $compactName = 'film';
                break;
            case 'drama':
                $query = DramaApplication::query();
                $view = 'reports.drama_report.dramaReport';
                $filename = 'drama_report.xlsx';
                $compactName = 'drama';
                break;
            case 'docufilm':
                $query = DocufilmApplication::query();
                $view = 'reports.pramanno_report.pramannoReport';
                $filename = 'docufilm_report.xlsx';
                $compactName = 'pramanno';
                break;
            case 'reality':
                $query = RealityApplication::query();
                $view = 'reports.reality_report.realityReport';
                $filename = 'reality_report.xlsx';
                $compactName = 'reality';
                break;
            default:
                abort(404, 'Report type not found');
        }
        $data = $query->where('producer_id', $producerId)
        ->when(!empty($request->from_date) && !empty($request->to_date), function ($query) use ($request) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        })
        ->when(!empty($request->status), function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->get();
        $viewData = [$compactName => $data];
        // dd($data);
        return Excel::download(new ViewExport($view, $viewData), $filename);
    }
}
