<?php

namespace App\Http\Controllers;
use App\Models\Noc;
use App\Models\ApprovalFlowMaster;
use App\Models\ApprovalFlowSteps;
use App\Models\ApprovalRequests;
use App\Models\ApprovalLogs;
use Illuminate\Http\Request;
use Flash;

class NocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('noc.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // $flow = ApprovalFlowMaster::where('name', 'like', '%Drama Application%')->first();
        // $step = ApprovalFlowSteps::where('from_role_id', $role_id)->where('flow_id', $flow->id)->first();
        // $next = ApprovalFlowSteps::where('from_role_id', $step->to_role_id)->where('flow_id', $flow->id)->first();

        /** @var Noc $Noc */

        try {
            \DB::beginTransaction();
            $input['token'] = 'NOC-' . strtotime(date('Y-m-d H:i:s'));
            $input['current_role_id'] = 1;
            $input['status'] = 'pending';
            $input['created_at'] = date('Y-m-d H:i:s');
            $input['updated_at'] = date('Y-m-d H:i:s');
            $noc = Noc::create($input);
            $data = array(
                'flow_id' => 0,
                'request_type' => 'NOC Application',
                'application_id' => $noc->id,
                'prev_role_id' => 0,
                'current_role_id' => 16,
                'next_role_id' => 16,
                'status' => 'on process',
                'created_by' => 0,
                'updated_by' =>0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert = ApprovalRequests::create($data);

            $data1 = array(
                'request_id' => $insert->id,
                'request_type' => 'NOC Application',
                'flow_id' => 0,
                'action_by' => 0,
                'action_role_id' => 0,
                'next_role_id' => 16,
                'status' => 'forward',
                'remarks' => 'New Application',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert1 = ApprovalLogs::create($data1);
            \DB::commit();

            Flash::success('Application saved successfully. Note: Please save the Registration No. ' . $noc->token . ' and wait for approval. Thank you.');
            return redirect(route('noc.show', $noc->id));
        } catch (\Exception $e) {
            \DB::rollBack();
            Flash::error($e->getMessage());
            return redirect(route('noc.create'));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $noc = Noc::find($id);
        return view('noc.show')->with('noc', $noc);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function showSearchList()
    {
        return view('noc.searchForm');
    }

    public function ajaxSearch(Request $request)
    {
        $token = $request->token_number;
        $noc = Noc::where('token', $token)->first();

        if (!$noc) {
            return response()->json(['status' => 'fail', 'result' => "<p class='text-danger center'> ⚠  কোনো তথ্য পাওয়া যায়নি </p>"]);
        }
        return response()->json(['status' => 'success', 'result' => $noc]);
    }

    public function downloadNoc($token)
    {
        $noc = Noc::where('token', $token)->first();
        return view('noc.downloadNoc')->with('noc', $noc);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
