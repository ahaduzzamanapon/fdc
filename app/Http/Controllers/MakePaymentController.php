<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AppBaseController;
use App\Models\MakePayment;
use App\Models\Package;
use App\Models\FilmPackage;
use Illuminate\Http\Request;
use Response;
use Auth;

class MakePaymentController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Auth::guard('producer')->check()) {
            $filmPackage = MakePayment::latest();
        } else {
            $filmPackage = MakePayment::latest()->where('created_by', Auth::guard('producer')->user()->id);
        }

        $filmPackage = $filmPackage->get();

        return view('make_payments.index')->with('filmPackage', $filmPackage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MakePayment  $makePayment
     * @return \Illuminate\Http\Response
     */
    public function show(MakePayment $makePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MakePayment  $makePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(MakePayment $makePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MakePayment  $makePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MakePayment $makePayment)
    {
        //
    }

    public function make_payment($package_id) {

        $transaction_id = 'TRN-' . time().rand(1000,9999);
        $package = Package::find($package_id);
        if (!$package) {
            Flash::error('Payment Failed');
            return redirect()->route('makePayments.index');
        }

        $film_package = new FilmPackage;
        $film_package->film_id = null;
        $film_package->package_id = $package_id;
        $film_package->type = 'film';
        $film_package->name = $package->name;
        $film_package->amount = $package->amount;
        $film_package->trn_id = $transaction_id;
        $film_package->status = 'pending';
        $film_package->created_by = Auth::guard('producer')->user()->id;
        $film_package->created_at = date('Y-m-d H:i:s');
        $film_package->updated_at = date('Y-m-d H:i:s');

        $film_package->save();
        return redirect()->route('innitiate_payment', ['transaction_id' => $transaction_id]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MakePayment  $makePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(MakePayment $makePayment)
    {
        //
    }
}
