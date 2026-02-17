<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFilmApplicationRequest;
use App\Http\Requests\ServiceApplicationRequest;
use App\Http\Requests\UpdateFilmApplicationRequest;
use App\Http\Controllers\AppBaseController;
use App\Mail\NotificationMail;
use App\Models\DocufilmApplication;
use App\Models\ApprovalFlowMaster;
use App\Models\ApprovalFlowSteps;
use App\Models\ApprovalRequests;
use App\Models\ApprovalLogs;
use App\Models\Package;
use App\Models\FilmPackage;
use App\Models\Producer;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

    ## Function for store doc as draft
    public function storeDocAsDraft(ServiceApplicationRequest $request) {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            ## Get data
            $producer = Auth::guard('producer')->user();
            $role_id = $producer->group_id;

            $flow = ApprovalFlowMaster::where('name', 'like', '%Documentary Film%')->first();
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
                $destinationPath = public_path('doc_applications/nid');

                ## Create folder if it doesn't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $fileName);
                $validated['nid_file'] = 'doc_applications/nid/' . $fileName;
            }

            ## Store data
            $docApplication = DocufilmApplication::create($validated);

            ## Store in approve request
            $approvalRequest = ApprovalRequests::create([
                'flow_id' => $flow->id,
                'request_type' => $flow->name,
                'application_id' => $docApplication->id,
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
                'remarks' => 'New Documentary Application',
            ]);

            DB::commit();

            Flash::success(__('messages.draft_saved_successfully'));
            return redirect()->route('docufilmApplications.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Drama Draft Save Failed', ['error' => $e->getMessage()]);

            Flash::error(__('messages.something_went_wrong'));
            return back()->withInput();
        }
    }

    ## Function to edit doc for status as draft
    public function editDocDraft($encryptedId) {
        try {
            $id = Crypt::decrypt($encryptedId); // decrypt the ID
            $film = DocufilmApplication::findOrFail($id);
            return view('docufilm_applications.edit_draft', [
                'film' => $film
            ]);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    ## Function for update draft doc
    public function updateDocDrama(ServiceApplicationRequest $request) {
        ## Request validate
        $validated = $request->validated();
        try {
            ## Begin DB transaction
            DB::beginTransaction();

            ## Get existing film draft
            $film = DocufilmApplication::findOrFail($request->film_id);

            ## Handle NID file upload
            if ($request->hasFile('nid_file')) {
                $file = $request->file('nid_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('doc_applications/nid', $filename, 'public');

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
            return redirect()->route('docufilmApplications.index');

        } catch (\Exception $e) {
            ## Rollback transaction on error
            DB::rollBack();

            ## Log the error for debugging
            Log::error('Documentary drama update failed: ' . $e->getMessage());

            Flash::success(__('messages.draft_update_failed'));
            return redirect()->route('docufilmApplications.index');
        }
    }
}
