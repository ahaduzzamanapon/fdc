<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use App\Models\Booking;
use App\Models\FilmApplication;
use App\Models\ProducerBalance;
use App\Models\RealityApplication;
use App\Models\DocufilmApplication;
use App\Models\DramaApplication;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Upazila;
use Illuminate\Support\Facades\DB;
use App\Models\District;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bookings = Booking::where('status', '!=', 'reject')
            ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN status = 'on process' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approveRow
                ")
            ->first();
        $films = FilmApplication::where('status', '!=', 'reject')
            ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN status = 'on process' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approveRow
                ")
            ->first();
        $dramas = DramaApplication::where('status', '!=', 'reject')
            ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN status = 'on process' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approveRow
                ")
            ->first();
        $docufilms = DocufilmApplication::where('status', '!=', 'reject')
            ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN status = 'on process' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approveRow
                ")
            ->first();
        $reality = RealityApplication::where('status', '!=', 'reject')
            ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN status = 'on process' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approveRow
                ")
            ->first();
        $producer = Producer::where('reg_status', '!=', 'rejected')
            ->selectRaw("
                    COUNT(*) AS totalRow,
                    SUM(CASE WHEN reg_status = 'pending' THEN 1 ELSE 0 END) AS pendingRow,
                    SUM(CASE WHEN reg_status = 'verified' THEN 1 ELSE 0 END) AS approveRow
                ")
            ->first();

        return view('index', compact('bookings', 'films', 'dramas', 'docufilms', 'reality', 'producer'));
    }

    public function get_districts(Request $request)
    {
        $districts = District::where('division_id', $request->division_id)->get(['id', 'name_bn as name']);
        if ($districts->isEmpty()) {
            return response()->json(['message' => 'No districts found'], 404);
        }
        return response()->json($districts);
    }

    public function get_upazilas(Request $request)
    {
        $upazilas = Upazila::where('dis_id', $request->district_id)->get(['id', 'name_bn as name']);
        if ($upazilas->isEmpty()) {
            return response()->json(['message' => __('messages.no_upazilas_found')], 404);
        }
        return response()->json($upazilas);
    }
}
