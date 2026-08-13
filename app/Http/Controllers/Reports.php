<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\FilmApplication;
use App\Models\DramaApplication;
use App\Models\RealityApplication;
use App\Models\DocufilmApplication;
use App\Models\MakePayment;
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
            case 'payment':
                $query = MakePayment::query();
                $view = 'reports.payment_report.paymentReport';
                $filename = 'payment_report.xlsx';
                $compactName = 'payments';
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

    // payment report
    public function payment_report_index()
    {
        return view('reports.payment_report.index');
    }
    public function payment_report_show(Request $request)
    {
        $query = MakePayment::query();

        // Producer লগইন করা থাকলে শুধুমাত্র তার নিজের পেমেন্ট ফিল্টার হবে
        if (Auth::guard('producer')->check()) {
            $producerId = Auth::guard('producer')->user()->id;
            $query->where('created_by', $producerId);
        }

        // সাধারণ ফিল্টার (তারিখ ও স্ট্যাটাস)
        $payments = $query
            ->when(!empty($request->from_date) && !empty($request->to_date), function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
            })
            ->when(!empty($request->status), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->get();

        $html = view('reports.payment_report.paymentReport', compact('payments'))->render();
        return response($html);
    }

    public function payment_exportReport(Request $request, $type)
    {
        // এক্সেলের জন্য আলাদা ডেডিকেটেড ভিউ ফাইল
        $view = 'reports.payment_report.payment_excel';
        $filename = 'payment_report_' . date('Y_m_d_His') . '.xlsx';
        $compactName = 'payments';

        $query = MakePayment::query();

        // Producer লগইন করা থাকলে শুধুমাত্র তার নিজের পেমেন্ট ফিল্টার হবে
        if (Auth::guard('producer')->check()) {
            $producerId = Auth::guard('producer')->user()->id;
            $query->where('created_by', $producerId);
        }

        // সাধারণ ফিল্টার (তারিখ ও স্ট্যাটাস)
        $data = $query
            ->when(!empty($request->from_date) && !empty($request->to_date), function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
            })
            ->when(!empty($request->status), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->get();

        $viewData = [$compactName => $data];

        return Excel::download(new ViewExport($view, $viewData), $filename);
    }
}
