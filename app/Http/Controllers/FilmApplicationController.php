<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFilmApplicationRequest;
use App\Http\Requests\UpdateFilmApplicationRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FilmApplication;
use App\Models\ApprovalFlowMaster;
use App\Models\ApprovalFlowSteps;
use App\Models\ApprovalRequests;
use App\Models\ApprovalLogs;
use App\Models\Package;
use App\Models\FilmPackage;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;

class FilmApplicationController extends AppBaseController
{
    /**
     * Display a listing of the FilmApplication.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

        if (!Auth::guard('producer')->check()) {
            $filmApplications = FilmApplication::latest();
        } else {
            $filmApplications = FilmApplication::latest()->where('producer_id', Auth::guard('producer')->user()->id);
        }

        $filmApplications = $filmApplications->get();

        return view('film_applications.index')->with('filmApplications', $filmApplications);
    }
    /**
     * Show the form for creating a new FilmApplication.
     *
     * @return Response
     */
    public function create()
    {
        return view('film_applications.create');
    }

    /**
     * Store a newly created FilmApplication in storage.
     *
     * @param CreateFilmApplicationRequest $request
     *
     * @return Response
     */
    public function store(CreateFilmApplicationRequest $request)
    {
        $input = $request->all();
        $producer = Auth::guard('producer')->user();
        $role_id = $producer->group_id;
        $flow = ApprovalFlowMaster::where('name', 'like', '%Film Application%')->first();
        $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
        $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();

        /** @var FilmApplication $filmApplication */

        try {
            \DB::beginTransaction();
            $input['producer_id'] = $producer->id;
            $input['desk_id'] = $step->to_role_id;
            $input['status'] = 'on process';
            $filmApplication = FilmApplication::create($input);
            $data = array(
                'flow_id' => $flow->id,
                'request_type' => $flow->name,
                'application_id' => $filmApplication->id,
                'prev_role_id' => $role_id,
                'current_role_id' => $step->to_role_id,
                'next_role_id' => $next->to_role_id,
                'status' => 'on process',
                'created_by' => $producer->id,
                'updated_by' => $producer->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert = ApprovalRequests::create($data);

            $data1 = array(
                'request_id' => $insert->id,
                'request_type' => $flow->name,
                'flow_id' => $flow->id,
                'action_by' => $producer->id,
                'action_role_id' => $role_id,
                'next_role_id' => $step->to_role_id,
                'status' => 'forward',
                'remarks' => 'New Application',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert1 = ApprovalLogs::create($data1);

            \DB::commit();

            Flash::success('Film Application saved successfully.');
            return redirect(route('filmApplications.index'));
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error($e->getMessage());
            return redirect(route('filmApplications.index'));
        }
    }

    /**
     * Display the specified FilmApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FilmApplication $filmApplication */
        $filmApplication = FilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Film Application not found');

            return redirect(route('filmApplications.index'));
        }

        return view('film_applications.show')->with('filmApplication', $filmApplication);
    }

    /**
     * Show the form for editing the specified FilmApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var FilmApplication $filmApplication */
        $filmApplication = FilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Film Application not found');

            return redirect(route('filmApplications.index'));
        }

        return view('film_applications.edit')->with('filmApplication', $filmApplication);
    }

    /**
     * Update the specified FilmApplication in storage.
     *
     * @param int $id
     * @param UpdateFilmApplicationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFilmApplicationRequest $request)
    {
        /** @var FilmApplication $filmApplication */
        $filmApplication = FilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Film Application not found');

            return redirect(route('filmApplications.index'));
        }

        $filmApplication->fill($request->all());
        $filmApplication->save();

        Flash::success('Film Application updated successfully.');

        return redirect(route('filmApplications.index'));
    }

    public function forward_table(Request $request)
    {
        $user = Auth::user()->user_role;
        $films = FilmApplication::latest()->where('status', 'on process')->where('desk_id', $user)->get();
        return view('film_applications.index')->with('filmApplications', $films);
    }
    public function forward(FilmApplication $filmApplication, $desk)
    {
        $app_id = $filmApplication->id;
        $role_id = $filmApplication->desk_id;
        $auth_user = ApprovalRequests::where('application_id', $app_id)->where('request_type', 'Film Application')->where('current_role_id', $role_id)->first();
        $logs = ApprovalLogs::where('request_id', $auth_user->id)->where('flow_id', $auth_user->flow_id)->get();

        return view('film_applications.forward', [
            'film' => $filmApplication,
            'auth_user' => $auth_user,
            'logs' => $logs,
        ]);
    }
    public function update_status(Request $request)
    {
        $film = FilmApplication::find($request->film_id);
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

        // filmapplications
        $data = array(
            'desk_id' => $current_role_id,
            'status' => $status,
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
            FilmApplication::where('id', $request->film_id)->update($data);
            ApprovalRequests::where('id', $request->request_id)->update($data1);
            ApprovalLogs::create($data2);
            \DB::commit();
            Flash::success('Film Application updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error('Film Application update failed. Please try again later.');
        }

        return redirect(route('filmApplications.forward.table'));
    }












    public function backward_table(Request $request)
    {
        $my_all_permissions=my_all_permissions();
        $filmApplications = FilmApplication::latest()
            ->where('state', 'back')
            ->whereIn('desk', $my_all_permissions)
            ->where('desk', '!=', 'All Desks Completed')
            ->get();
        return view('film_applications.index')
            ->with('filmApplications', $filmApplications);
    }
    public function back(FilmApplication $filmApplication, $desk)
    {
        // Ensure the current desk and state match before backing
        $filmApplication->update(['desk' => $desk]);
        return redirect()->route('filmApplications.index')->with('success', 'Film application forwarded successfully!');
    }

    public function finalForwardToMD(FilmApplication $filmApplication, $desk)
    {
        $filmApplication->update(['desk' => 'All Desks Completed Waiting for MD Approval']); // Final desk, MD
        return redirect()->route('filmApplications.index')->with('success', 'Film application forwarded to MD!');
    }
    public function approve_md(FilmApplication $filmApplication, $desk)
    {
        $filmApplication->update(['desk' => 'MD Approved']); // Final desk, MD
        return redirect()->route('filmApplications.index')->with('success', 'Film application forwarded to MD!');
    }







    /**
     * Remove the specified FilmApplication from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FilmApplication $filmApplication */
        $filmApplication = FilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Film Application not found');

            return redirect(route('filmApplications.index'));
        }

        $filmApplication->delete();

        Flash::success('Film Application deleted successfully.');

        return redirect(route('filmApplications.index'));
    }

    public function make_payment(FilmApplication $filmApplication, $package_id) {

        $transaction_id = 'TRN-' . time().rand(1000,9999);
        $package = Package::find($package_id);
        if (!$package) {
            Flash::error('Payment Failed');
            return redirect()->route('filmApplications.index');
        }

        $film_package = new FilmPackage;
        $film_package->film_id = $filmApplication->id;
        $film_package->package_id = $package_id;
        $film_package->amount = $package->amount;
        $film_package->trn_id = $transaction_id;
        $film_package->status = 'pending';
        $film_package->save();
        return redirect()->route('innitiate_payment', ['transaction_id' => $transaction_id]);

    }

    public function payment_data(FilmApplication $filmApplication)
    {

        $filmPackage = FilmPackage::where('film_id', $filmApplication->id)
            ->join('packages', 'film_packages.package_id', '=', 'packages.id')
            ->select('film_packages.*', 'packages.name as package_name')
            ->get();




        return view('film_applications.payment_data', compact('filmPackage', 'filmApplication'));
    }

    public function single_payment_receipt(FilmPackage $filmPackage)
    {
        $filmPackage->load('filmApplication', 'package');
        $filmApplication = $filmPackage->filmApplication;
        return view('film_applications.payment_receipt', compact('filmPackage', 'filmApplication'));
    }
}
