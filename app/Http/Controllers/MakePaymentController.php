<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AppBaseController;
use App\Models\MakePayment;
use App\Models\Package;
use App\Models\FilmPackage;
use App\Models\ApprovalFlowSteps;
use App\Models\ApprovalRequests;
use App\Models\ApprovalLogs;
use Illuminate\Http\Request;
use Response;
use Auth;
use Flash;

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
        $film_package->review_status = 'pending';
        $film_package->created_by = Auth::guard('producer')->user()->id;
        $film_package->created_at = date('Y-m-d H:i:s');
        $film_package->updated_at = date('Y-m-d H:i:s');

        $film_package->save();
        return redirect()->route('innitiate_payment', ['transaction_id' => $transaction_id]);

    }

    public function forward_table(Request $request)
    {
        $user = Auth::user()->user_role;
        $films = FilmPackage::latest()->where('review_status', 'on process')->where('desk_id', $user)->get();
        return view('make_payments.index')->with('filmPackage', $films);
    }


    public function forward(MakePayment $makePayment, $desk)
    {
        $app_id = $makePayment->id;
        $role_id = $makePayment->desk_id;
        $auth_user = ApprovalRequests::where('application_id', $app_id)->where('request_type', 'Payment Flow')->where('current_role_id', $role_id)->first();
        $logs = ApprovalLogs::where('request_id', $auth_user->id)->where('flow_id', $auth_user->flow_id)->get();
        // dd($makePayment);

        return view('make_payments.forward', [
            'film' => $makePayment,
            'auth_user' => $auth_user,
            'logs' => $logs,
        ]);
    }


    public function update_status(Request $request)
    {
        $film = MakePayment::find($request->film_id);
        $steps = ApprovalRequests::find($request->request_id);

        if ($request->status == 'backward') {
            $prev = ApprovalFlowSteps::where('to_role_id', $steps->prev_role_id)->where('flow_id', $steps->flow_id)->first();
            $prev_role_id = !empty($prev->from_role_id) ? $prev->from_role_id : $steps->current_role_id;
            $current_role_id = $steps->prev_role_id;
            $next_role_id = $steps->current_role_id;
            $fstatus = 'backward';
            $status = "on process";
        } else if ($request->status == 'forward') {
            $next = ApprovalFlowSteps::where('from_role_id', $steps->next_role_id)->where('flow_id', $steps->flow_id)->first();
            $prev_role_id = $steps->current_role_id;
            $current_role_id = $steps->next_role_id;
            $next_role_id = !empty($next->to_role_id) ? $next->to_role_id : $steps->current_role_id;
            $fstatus = 'forward';
            $status = "on process";
        } else {
            $prev_role_id = $steps->current_role_id;
            $current_role_id = $steps->current_role_id;
            $next_role_id = $steps->current_role_id;
            $fstatus = $request->status;
            $status = $request->status;
        }

        // film_packages
        $data = array(
            'desk_id' => $current_role_id,
            'review_status' => $status,
            'updated_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        // approval_requests
        $data1 = array(
            'prev_role_id' => $prev_role_id,
            'current_role_id' => $current_role_id,
            'next_role_id' => $next_role_id,
            'status' => $status,
            'updated_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        // approval_logs
        $data2 = array(
            'request_id' => $request->request_id,
            'request_type' => $steps->request_type,
            'flow_id' => $steps->flow_id,
            'action_by' => Auth::user()->id,
            'action_role_id' => Auth::user()->user_role,
            'next_role_id' => $current_role_id,
            'status' => $fstatus,
            'remarks' => $request->log_remarks,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        try {
            \DB::beginTransaction();
            MakePayment::where('id', $request->film_id)->update($data);
            ApprovalRequests::where('id', $request->request_id)->update($data1);
            ApprovalLogs::create($data2);
            \DB::commit();
            Flash::success('Payment updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error('Payment update failed. Please try again later.');
        }

        return redirect(route('makePayments.forward.table'));
    }

    function package() {
        $films = array();
        return view('make_payments.package')->with('filmPackage', $films);
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
