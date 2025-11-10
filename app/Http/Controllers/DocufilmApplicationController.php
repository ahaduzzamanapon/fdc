<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFilmApplicationRequest;
use App\Http\Requests\UpdateFilmApplicationRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\DocufilmApplication;
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

class DocufilmApplicationController extends AppBaseController
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
            $filmApplications = DocufilmApplication::latest();
        } else {
            $filmApplications = DocufilmApplication::latest()->where('producer_id', Auth::guard('producer')->user()->id);
        }

        $filmApplications = $filmApplications->get();

        return view('docufilm_applications.index')->with('filmApplications', $filmApplications);
    }
    /**
     * Show the form for creating a new DocufilmApplication.
     *
     * @return Response
     */
    public function create()
    {
        return view('docufilm_applications.create');
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
        $flow = ApprovalFlowMaster::where('name', 'like', '%Documentary Film%')->first();
        $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
        $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();
        // dd($flow);
        /** @var DocufilmApplication $DocufilmApplication */

        try {
            \DB::beginTransaction();
            $input['producer_id'] = $producer->id;
            $input['desk_id'] = $step->to_role_id;
            $input['status'] = 'on process';
            $DocufilmApplication = DocufilmApplication::create($input);
            $data = array(
                'flow_id' => $flow->id,
                'request_type' => $flow->name,
                'application_id' => $DocufilmApplication->id,
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

            Flash::success('Documentary Film saved successfully.');
            return redirect(route('docufilmApplications.index'));
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error($e->getMessage());
            return redirect(route('docufilmApplications.index'));
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
        /** @var DocufilmApplication $filmApplication */
        $filmApplication = DocufilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Film Application not found');

            return redirect(route('filmApplications.index'));
        }

        return view('docufilm_applications.show')->with('filmApplication', $filmApplication);
    }

    /**
     * Show the form for editing the specified DocufilmApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var DocufilmApplication $filmApplication */
        $filmApplication = DocufilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Film Application not found');

            return redirect(route('filmApplications.index'));
        }

        return view('docufilm_applications.edit')->with('filmApplication', $filmApplication);
    }

    /**
     * Update the specified DocufilmApplication in storage.
     *
     * @param int $id
     * @param UpdateDocufilmApplicationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocufilmApplicationRequest $request)
    {
        /** @var DocufilmApplication $filmApplication */
        $filmApplication = DocufilmApplication::find($id);

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
        $films = DocufilmApplication::latest()->where('status', 'on process')->where('desk_id', $user)->get();
        return view('docufilm_applications.index')->with('filmApplications', $films);
    }
    public function forward(DocufilmApplication $docufilmApplication, $desk)
    {
        $app_id = $docufilmApplication->id;
        $role_id = $docufilmApplication->desk_id;
        $auth_user = ApprovalRequests::where('application_id', $app_id)->where('request_type', 'Documentary Film')->where('current_role_id', $role_id)->first();
        $logs = ApprovalLogs::where('request_id', $auth_user->id)->where('flow_id', $auth_user->flow_id)->get();

        return view('docufilm_applications.forward', [
            'film' => $docufilmApplication,
            'auth_user' => $auth_user,
            'logs' => $logs,
        ]);
    }


    public function update_status(Request $request)
    {
        $film = DocufilmApplication::find($request->film_id);
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
            DocufilmApplication::where('id', $request->film_id)->update($data);
            ApprovalRequests::where('id', $request->request_id)->update($data1);
            ApprovalLogs::create($data2);
            \DB::commit();
            Flash::success('Documentary Application updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error('Documentary Application update failed. Please try again later.');
        }

        return redirect(route('docufilmApplications.forward.table'));
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
        /** @var DocufilmApplication $filmApplication */
        $filmApplication = DocufilmApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Docufilm Application not found');

            return redirect(route('docufilmApplications.index'));
        }

        $filmApplication->delete();

        Flash::success('Docufilm Application deleted successfully.');

        return redirect(route('docufilmApplications.index'));
    }
}
