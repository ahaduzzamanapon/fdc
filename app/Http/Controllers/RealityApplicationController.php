<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFilmApplicationRequest;
use App\Http\Requests\ServiceApplicationRequest;
use App\Http\Requests\UpdateFilmApplicationRequest;
use App\Http\Controllers\AppBaseController;
use App\Mail\NotificationMail;
use App\Models\Producer;
use App\Models\RealityApplication;
use App\Models\ApprovalFlowMaster;
use App\Models\ApprovalFlowSteps;
use App\Models\ApprovalRequests;
use App\Models\ApprovalLogs;
use App\Models\Package;
use App\Models\FilmPackage;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        $flow = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $auth_user->flow_id)->first();
        // dd($flow);

        return view('reality_applications.forward', [
            'film' => $realityApplication,
            'auth_user' => $auth_user,
            'logs' => $logs,
            'flow' => $flow
        ]);
    }


    public function update_status(Request $request)
    {
        $film = RealityApplication::find($request->film_id);
        $steps = ApprovalRequests::find($request->request_id);

        ## Get producer data
        $producer = Producer::findOrFail($film->producer_id);

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

            ## Send mail
            if($request->status === 'approved' || $request->status === 'reject') {
                try {
                    Mail::to($producer->email)->queue(new NotificationMail([
                        'type' => 'service_acceptance',
                        'subject' => 'আপনার আবেদন গ্রহণ করা হয়েছে - ' . $steps->request_type,
                        'producer_name' => $producer->owners_name,
                        'status' => $request->status,
                        'service_name' => $steps->request_type,
                        'title' => $film->film_title
                    ]));

                } catch (\Throwable $e) {
                    \Log::error('Mail failed', ['error' => $e->getMessage()]);
                }
            }

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

    ## Function for store reality as draft
    public function storeRealityAsDraft(ServiceApplicationRequest $request) {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            ## Get data
            $producer = Auth::guard('producer')->user();
            $role_id = $producer->group_id;

            $flow = ApprovalFlowMaster::where('name', 'like', '%Reality Application%')->first();
            ## Check
            if (!$flow) {
                throw new \Exception('Approval flow not found.');
            }

            ## Check
            $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
            if (!$step) {
                throw new \Exception('Approval step not found.');
            }

            $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();
            ## Check
            if (!$next) {
                throw new \Exception('Approval step not found.');
            }

            ##
            $validated['producer_id'] = $producer->id;
            $validated['status'] = 'draft';
            $validated['desk_id'] = $step->to_role_id;

            ## Store the NID file
            if ($request->hasFile('nid_file')) {
                $file = $request->file('nid_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('reality_applications/nid');

                ## Create folder if it doesn't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $fileName);
                $validated['nid_file'] = 'reality_applications/nid/' . $fileName;
            }

            ## Store data
            $realityApplication = RealityApplication::create($validated);

            ## Store in approve request
            $approvalRequest = ApprovalRequests::create([
                'flow_id' => $flow->id,
                'request_type' => $flow->name,
                'application_id' => $realityApplication->id,
                'prev_role_id' => $role_id,
                'current_role_id' => $step->to_role_id,
                'next_role_id' => $next?->to_role_id,
                'status' => 'on process',
                'created_by' => $producer->id,
                'updated_by' => $producer->id,
            ]);

            ## Store in logs
            ApprovalLogs::create([
                'request_id' => $approvalRequest->id,
                'request_type' => $flow->name,
                'flow_id' => $flow->id,
                'action_by' => $producer->id,
                'action_role_id' => $role_id,
                'next_role_id' => $step->to_role_id,
                'status' => 'forward',
                'remarks' => 'New Reality Show Application',
            ]);

            DB::commit();

            Flash::success(__('messages.draft_saved_successfully'));
            return redirect()->route('realityApplications.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Drama Draft Save Failed', ['error' => $e->getMessage()]);

            Flash::error(__('messages.something_went_wrong'));
            return back()->withInput();
        }
    }

    ## Function to edit reality for status as draft
    public function editRealityDraft($encryptedId) {
        try {
            $id = Crypt::decrypt($encryptedId);
            $film = RealityApplication::findOrFail($id);
            return view('reality_applications.edit_draft', [
                'film' => $film
            ]);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    ## Function for update draft reality
    public function updateRealityDrama(ServiceApplicationRequest $request) {
        ## Request validate
        $validated = $request->validated();
        try {
            ## Begin DB transaction
            DB::beginTransaction();

            ## Get existing film draft
            $film = RealityApplication::findOrFail($request->film_id);

            ## Handle NID file upload
            if ($request->hasFile('nid_file')) {
                $file = $request->file('nid_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('reality_applications/nid', $filename, 'public');

                ## Delete old file if exists
                if (!empty($film->nid_file) && \Storage::disk('public')->exists($film->nid_file)) {
                    \Storage::disk('public')->delete($film->nid_file);
                }

                $validated['nid_file'] = $path;
            }

            $validated['status'] = 'on process';

            ## Update the draft
            $film->update($validated);

            ## Commit transaction
            DB::commit();

            ## Redirect after success
            \Laracasts\Flash\Flash::success(__('messages.draft_updated_successfully'));
            return redirect()->route('realityApplications.index');

        } catch (\Exception $e) {
            ## Rollback transaction on error
            DB::rollBack();

            ## Log the error for debugging
            Log::error('Reality show update failed: ' . $e->getMessage());

            Flash::success(__('messages.draft_update_failed'));
            return redirect()->route('realityApplications.index');
        }
    }
}
