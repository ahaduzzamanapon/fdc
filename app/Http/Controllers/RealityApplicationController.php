<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFilmApplicationRequest;
use App\Http\Requests\UpdateFilmApplicationRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\RealityApplication;
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

class RealityApplicationController extends AppBaseController
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
            $filmApplications = RealityApplication::latest();
        } else {
            $filmApplications = RealityApplication::latest()->where('producer_id', Auth::guard('producer')->user()->id);
        }

        $filmApplications = $filmApplications->get();

        return view('reality_applications.index')->with('filmApplications', $filmApplications);
    }
    /**
     * Show the form for creating a new RealityApplication.
     *
     * @return Response
     */
    public function create()
    {
        return view('reality_applications.create');
    }

    /**
     * Store a newly created FilmApplication in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $producer = Auth::guard('producer')->user();
        $role_id = $producer->group_id;
        $flow = ApprovalFlowMaster::where('name', 'like', '%Reality Application%')->first();
        $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
        $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();

        /** @var RealityApplication $RealityApplication */

        try {
            \DB::beginTransaction();
            $input['producer_id'] = $producer->id;
            $input['desk_id'] = $step->to_role_id;
            $input['status'] = 'on process';
            $realityApplication = RealityApplication::create($input);
            $data = array(
                'flow_id' => $flow->id,
                'request_type' => $flow->name,
                'application_id' => $realityApplication->id,
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

            Flash::success('Reality Application saved successfully.');
            return redirect(route('realityApplications.index'));
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error($e->getMessage());
            return redirect(route('realityApplications.index'));
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
        /** @var RealityApplication $filmApplication */
        $filmApplication = RealityApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Reality Application not found');

            return redirect(route('realityApplications.index'));
        }

        return view('reality_applications.show')->with('filmApplication', $filmApplication);
    }

    /**
     * Show the form for editing the specified DramaApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var RealityApplication $filmApplication */
        $filmApplication = RealityApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Reality Application not found');

            return redirect(route('realityApplications.index'));
        }

        return view('reality_applications.edit')->with('filmApplication', $filmApplication);
    }

    /**
     * Update the specified DramaApplication in storage.
     *
     * @param int $id
     * @param UpdateRealityApplicationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRealityApplicationRequest $request)
    {
        /** @var RealityApplication $filmApplication */
        $filmApplication = RealityApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Reality Application not found');

            return redirect(route('realityApplications.index'));
        }

        $filmApplication->fill($request->all());
        $filmApplication->save();

        Flash::success('Reality Application updated successfully.');

        return redirect(route('realityApplications.index'));
    }

    public function forward_table(Request $request)
    {
        $user = Auth::user()->user_role;
        $films = RealityApplication::latest()->where('status', 'on process')->where('desk_id', $user)->get();
        return view('reality_applications.index')->with('filmApplications', $films);
    }
    public function forward(RealityApplication $realityApplication, $desk)
    {
        $app_id = $realityApplication->id;
        $role_id = $realityApplication->desk_id;
        $auth_user = ApprovalRequests::where('application_id', $app_id)->where('request_type', 'Reality Application')->where('current_role_id', $role_id)->first();
        $logs = ApprovalLogs::where('request_id', $auth_user->id)->where('flow_id', $auth_user->flow_id)->get();
        // dd($logs);

        return view('reality_applications.forward', [
            'film' => $realityApplication,
            'auth_user' => $auth_user,
            'logs' => $logs,
        ]);
    }


    public function update_status(Request $request)
    {
        $film = RealityApplication::find($request->film_id);
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

        if (empty(Auth::user())) {
            $users = Auth::guard('producer')->user();
            $user_id = $users->id;
            $user_role = $users->group_id;
        } else {
            $users = Auth::user();
            $user_id = $users->id;
            $user_role = $users->user_role;
        }

        // filmapplications
        $data = array(
            'desk_id' => $current_role_id,
            'status' => $status,
            'updated_by' => $user_id,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        // approval_requests
        $data1 = array(
            'prev_role_id' => $prev_role_id,
            'current_role_id' => $current_role_id,
            'next_role_id' => $next_role_id,
            'status' => $status,
            'updated_by' => $user_id,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        // approval_logs
        $data2 = array(
            'request_id' => $request->request_id,
            'request_type' => $steps->request_type,
            'flow_id' => $steps->flow_id,
            'action_by' => $user_id,
            'action_role_id' => $user_role,
            'next_role_id' => $current_role_id,
            'status' => $fstatus,
            'remarks' => $request->log_remarks,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $user_id,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        try {
            \DB::beginTransaction();
            RealityApplication::where('id', $request->film_id)->update($data);
            ApprovalRequests::where('id', $request->request_id)->update($data1);
            ApprovalLogs::create($data2);
            \DB::commit();
            Flash::success('Reality Application updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error('Reality Application update failed. Please try again later.');
        }

        if (empty(Auth::user())) {
            return redirect(route('realityApplications.index'));
        } else {
            return redirect(route('realityApplications.forward.table'));
        }
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
        /** @var DramaApplication $filmApplication */
        $filmApplication = RealityApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Reality Application not found');

            return redirect(route('realityApplications.index'));
        }

        $filmApplication->delete();

        Flash::success('Reality Application deleted successfully.');

        return redirect(route('realityApplications.index'));
    }
}
