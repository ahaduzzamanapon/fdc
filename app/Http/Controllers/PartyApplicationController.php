<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFilmApplicationRequest;
use App\Http\Requests\UpdateFilmApplicationRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\PartyApplication;
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

class PartyApplicationController extends AppBaseController
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
            $filmApplications = PartyApplication::latest();
        } else {
            $filmApplications = PartyApplication::latest()->where('id', Auth::guard('producer')->user()->id);
        }

        $filmApplications = $filmApplications->get();

        return view('party_applications.index')->with('filmApplications', $filmApplications);
    }
    /**
     * Show the form for creating a new PartyApplication.
     *
     * @return Response
     */
    public function create()
    {
        return view('party_applications.create');
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

        $input['trade_license_validity_date'] = date('Y-m-d', strtotime($input['trade_license_validity_date']));

        // Handle single file uploads
        $input_file = [
            'bank_attachment',
            'tin_attachment',
            'vat_attachment',
            'trade_license_attachment',
            'nominee_photo',
        ];

        foreach ($input_file as $file_name) {
            if ($request->hasFile($file_name)) {
                $file = $request->file($file_name);
                $folder = 'producers_file/' . $file_name;
                $customName = 'producers_file-' . $file_name . '-' . time();
                $input[$file_name] = uploadFile($file, $folder, $customName);
            } else {
                unset($input[$file_name]);
            }
        }

        // Handle multiple file-name pairs as JSON and store in a single string column
        $multi_file_fields = [
            'partnership' => 'partnership_attachment',
            'ltd_company' => 'ltd_company_attachment',
            'somobay' => 'somobay_attachment',
            'other' => 'other_attachment',
        ];

        foreach ($multi_file_fields as $field => $fileField) {
            $nameInput = $request->input($field . '_name', []);
            $fileInput = $request->file($fileField, []);
            $combinedData = [];

            foreach ($nameInput as $index => $name) {
                if (!empty($name) && isset($fileInput[$index])) {
                    $file = $fileInput[$index];
                    $folder = 'producers_file/' . $fileField;
                    $customName = $field . '-' . $index . '-' . time();
                    $filePath = uploadFile($file, $folder, $customName);
                    $combinedData[] = [
                        'name' => $name,
                        'file' => $filePath,
                    ];
                }
            }

            // Save as JSON string into corresponding single column
            $columnName = $field . '_agreement'; // e.g. partnership_agreement
            $input[$columnName] = json_encode($combinedData); // Store as JSON string
        }
        $input['other_attachment'] = $input['other_agreement'];
        unset(
            $input['partnership_name'],
            $input['ltd_company_name'],
            $input['somobay_name'],
            $input['other_name'],
            $input['partnership_attachment'],
            $input['ltd_company_attachment'],
            $input['somobay_attachment'],
            $input['other_agreement'],
            $input['_token'],
        );

        // Save producer
        $producer = Auth::guard('producer')->user();
        $role_id = $producer->group_id;
        $flow = ApprovalFlowMaster::where('name', 'like', '%Party Application%')->first();
        $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
        $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();

        /** @var PartyApplication $PartyApplication */

        try {
            \DB::beginTransaction();
            $input['desk_id'] = $step->to_role_id;
            $input['status'] = 'on process';
            $partyApplication = PartyApplication::where('id', $producer->id)->update($input);
            $data = array(
                'flow_id' => $flow->id,
                'request_type' => $flow->name,
                'application_id' => $producer->id,
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

            Flash::success('Party Application saved successfully.');
            return redirect(route('producer.dashboard'));
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error($e->getMessage());
            return redirect(route('partyApplications.index'));
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
        /** @var PartyApplication $filmApplication */
        $filmApplication = PartyApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Party Application not found');

            return redirect(route('partyApplications.index'));
        }

        return view('party_applications.show')->with('filmApplication', $filmApplication);
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
        /** @var PartyApplication $filmApplication */
        $filmApplication = PartyApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Party Application not found');

            return redirect(route('partyApplications.index'));
        }

        return view('party_applications.edit')->with('filmApplication', $filmApplication);
    }

    /**
     * Update the specified PartyApplication in storage.
     *
     * @param int $id
     * @param UpdatePartyApplicationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePartyApplicationRequest $request)
    {
        /** @var PartyApplication $filmApplication */
        $filmApplication = PartyApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Party Application not found');

            return redirect(route('partyApplications.index'));
        }

        $filmApplication->fill($request->all());
        $filmApplication->save();

        Flash::success('Party Application updated successfully.');

        return redirect(route('partyApplications.index'));
    }

    public function forward_table(Request $request)
    {
        $user = Auth::user()->user_role;
        $films = PartyApplication::latest()->where('status', 'on process')->where('desk_id', $user)->get();
        return view('party_applications.index')->with('filmApplications', $films);
    }
    public function forward(PartyApplication $partyApplication, $desk)
    {
        $app_id = $partyApplication->id;
        $role_id = $partyApplication->desk_id;
        $auth_user = ApprovalRequests::where('application_id', $app_id)->where('request_type', 'Party Application')->where('current_role_id', $role_id)->first();
        $logs = ApprovalLogs::where('request_id', $auth_user->id)->where('flow_id', $auth_user->flow_id)->get();
        // dd($logs);

        return view('party_applications.forward', [
            'film' => $partyApplication,
            'auth_user' => $auth_user,
            'logs' => $logs,
        ]);
    }


    public function update_status(Request $request)
    {
        $film = PartyApplication::find($request->film_id);
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
        if ($request->status == 'approved') {
            $types = 'party';
        } else {
            $types = 'citizen';
        }

        // filmapplications
        $data = array(
            'desk_id' => $current_role_id,
            'types' => $types,
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
            PartyApplication::where('id', $request->film_id)->update($data);
            ApprovalRequests::where('id', $request->request_id)->update($data1);
            ApprovalLogs::create($data2);
            \DB::commit();
            Flash::success('Party Application updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error('Party Application update failed. Please try again later.');
        }

        return redirect(route('partyApplications.forward.table'));
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
        /** @var PartyApplication $filmApplication */
        $filmApplication = PartyApplication::find($id);

        if (empty($filmApplication)) {
            Flash::error('Party Application not found');

            return redirect(route('partyApplications.index'));
        }

        $filmApplication->delete();

        Flash::success('Party Application deleted successfully.');

        return redirect(route('partyApplications.index'));
    }
}
