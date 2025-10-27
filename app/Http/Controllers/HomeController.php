<?php

namespace App\Http\Controllers;

use App\Models\FilmApplication;
use App\Models\Producer;
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
        $totalRunningMovies = FilmApplication::where('status', 'running')->count();
        $totalCompletedMovies = FilmApplication::where('status', 'completed')->count();
        $moviesAwaitingApproval = FilmApplication::where('status', 'pending')->count();
        $commercialsAwaitingApproval = FilmApplication::where('status', 'pending')->count();
        $totalProducerList = Producer::count();
        $totalApprovedProducerPendingList = Producer::where('status', 'pending')->count();

        return view('index', compact('totalRunningMovies', 'totalCompletedMovies', 'moviesAwaitingApproval', 'commercialsAwaitingApproval', 'totalProducerList', 'totalApprovedProducerPendingList'));
    }
  

    public function get_upazilas(Request $request){

     

        $upazilas = Upazila::where('dis_id', $request->district_id)->get(['id', 'name_en as name']);
        if ($upazilas->isEmpty()) {
            return response()->json(['message' => __('messages.no_upazilas_found')], 404);
        }
        return response()->json($upazilas);
    }

  
}
