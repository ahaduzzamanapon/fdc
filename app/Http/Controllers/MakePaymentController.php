<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AppBaseController;
use App\Models\MakePayment;
use App\Models\Package;
use App\Models\Package_details;
use App\Models\FilmPackage;
use App\Models\ApprovalFlowMaster;
use App\Models\ApprovalFlowSteps;
use App\Models\ApprovalRequests;
use App\Models\ApprovalLogs;
use App\Models\Item;
use Illuminate\Http\Request;
use Response;
use Auth;
use Flash;
use Illuminate\Support\Facades\DB;

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

    public function make_payment_cm($package_id) {

        $transaction_id = 'TRN-' . time().rand(1000,9999);
        $package = Package::find($package_id);

        if (!$package) {
            Flash::error('Payment Failed');
            return redirect()->route('makePayments.cm_package_list');
        }
        $data = array(
            'trn_id' => $transaction_id,
            'pay_status' => 'on processing',
            'updated_by' => Auth::guard('producer')->user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        Package::where('id', $package_id)->update($data);
        return redirect()->route('initiate_cm_payment', ['transaction_id' => $transaction_id]);
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

    // package section
    function package() {
        $films = array();
        return view('make_payments.package')->with('filmPackage', $films);
    }

    public function get_items_by_type(Request $request)
    {
        $items = Item::where('service_type', $request->service_type)->get();
        return response()->json($items);
    }

    function cm_package_list() {
        $producer = Auth::guard('producer')->user();
        $films = Package::where('producer_id', $producer->id)->get();
        return view('make_payments.cm_package_list')->with('filmPackage', $films);
    }

    function makeCustomPackage() {
        $films = array();
        return view('make_payments.custom_package')->with('filmPackage', $films);
    }

    public function custom_package_store(Request $request)
    {
        $producer = Auth::guard('producer')->user();
        $check = Package::where('producer_id', $producer->id)->orderBy('id', 'desc')->first();
        dd($check->id);

        // if (!empty($check)) {
        //     Flash::error('You have already applied for this application.');
        //     return back();
        // }

        $role_id = $producer->group_id;
        $flow = ApprovalFlowMaster::where('name', 'like', '%Custom Package Flow%')->first();
        $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
        $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();

        DB::beginTransaction();
        try {
            // 1. Create Booking
            $package = array(
                'name' => 'Custom Package '.$producer->id,
                'desk_id' => $step->to_role_id,
                'film_type' => $request->film_type,
                'film_id' => $request->film_id,
                'service_type' => $request->service_type,
                'producer_id' => $producer->id,
                'package_type' => 'custom',
                'request_amt' => $request->grand_amount,
                'amount' => $request->grand_amount,
                'type'  => $request->film_type,
                'status'  => 'on process',
                'description' => $request->description
            );
            $insert = Package::create($package);

            // 2. Loop through details
            $item_ids = $request->input('item_id');
            $item_amt = $request->input('item_amt');
            $days = $request->input('days');
            $item_amount = $request->input('item_total_amount');

            foreach ($item_ids as $i => $item_id) {
                Package_details::create([
                    'package_id' => $insert->id,
                    'item_id' => $item_ids[$i],
                    'item_amt' => $item_amt[$i],
                    'request_days' => $days[$i],
                    'request_total_amt' => $item_amount[$i],
                    'app_days' => $days[$i],
                    'app_total_amt' => $item_amount[$i]
                ]);
            }

            $data = array(
                'flow_id' => $flow->id,
                'request_type' => $flow->name,
                'application_id' => $insert->id,
                'prev_role_id' => $role_id,
                'current_role_id' => $step->to_role_id,
                'next_role_id' => $next->to_role_id,
                'status' => 'on process',
                'created_by' => $producer->id,
                'updated_by' => $producer->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert1 = ApprovalRequests::create($data);

            $data1 = array(
                'request_id' => $insert1->id,
                'request_type' => $flow->name,
                'flow_id' => $flow->id,
                'action_by' => $producer->id,
                'action_role_id' => $role_id,
                'next_role_id' => $step->to_role_id,
                'status' => 'forward',
                'remarks' => 'New Request Created',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert2 = ApprovalLogs::create($data1);

            DB::commit();
            Flash::success('Package created successfully!');
            return redirect(route('makePayments.cm_package_list'));
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Failed to create package: ' . $e->getMessage());
            return back()->with('error', 'Failed to create package: ' . $e->getMessage());
        }
    }
    public function cp_forward_table(Request $request)
    {
        $user = Auth::user()->user_role;
        $films = Package::latest()->where('status', 'on process')->where('desk_id', $user)->get();
        return view('make_payments.cm_package_list')->with('filmPackage', $films);
    }

    public function cp_forward($id)
    {
        $package = Package::find($id);
        $role_id = $package->desk_id;
        $auth_user = ApprovalRequests::where('application_id', $id)->where('request_type', 'Custom Package Flow')->where('current_role_id', $role_id)->first();
        $logs = ApprovalLogs::where('request_id', $auth_user->id)->where('flow_id', $auth_user->flow_id)->get();

        $details = Package_details::where('package_id', $id)
            ->join('items', 'items.id', '=', 'packages_details.item_id')
            ->select('packages_details.*', 'items.name_bn as item_name')
            ->get();
        // dd($details);

        return view('make_payments.cp_forward', [
            'film' => $package,
            'details' => $details,
            'auth_user' => $auth_user,
            'logs' => $logs,
        ]);
    }

    public function cp_update_status(Request $request)
    {
        // dd($request->all());
        $film = Package::find($request->film_id);
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
            'status' => $status,
            'pay_status' => $status == 'approved' ? 'unpaid' : null,
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

        $details_id = $request->input('details_id');
        $app_days = $request->input('app_days');
        $app_total_amt = $request->input('app_total_amt');

        try {
            \DB::beginTransaction();
            $package_amt = 0;
            foreach ($details_id as $i => $item_id) {
                $package_amt += $app_total_amt[$i];
                $details = array(
                    'app_days' => $app_days[$i],
                    'app_total_amt' => $app_total_amt[$i],  // $request->input('app_total_amt')[$i],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                Package_details::where('id', $item_id)->update($details);
            }

            // Add new element
            $data['amount'] = $package_amt;
            Package::where('id', $request->film_id)->update($data);

            \DB::commit();
            Flash::success('Package updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error('Package update failed. Please try again later.');
        }

        return redirect(route('makePayments.cp.forward.table'));
    }
    public function cm_payment_receipt($id)
    {
        $package = Package::where('trn_id', $id)->first();
        return view('make_payments.cm_payment_receipt', compact('package'));
    }

    // package section




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
