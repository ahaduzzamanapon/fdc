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
            // $data = array(
            //     'flow_id' => $flow->id,
            //     'request_type' => $flow->name,
            //     'application_id' => $noc->id,
            //     'prev_role_id' => $role_id,
            //     'current_role_id' => $step->to_role_id,
            //     'next_role_id' => $next->to_role_id,
            //     'status' => 'on process',
            //     'created_by' => $producer->id,
            //     'updated_by' => $producer->id,
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s')
            // );
            // $insert = ApprovalRequests::create($data);

            // $data1 = array(
            //     'request_id' => $insert->id,
            //     'request_type' => $flow->name,
            //     'flow_id' => $flow->id,
            //     'action_by' => $producer->id,
            //     'action_role_id' => $role_id,
            //     'next_role_id' => $step->to_role_id,
            //     'status' => 'forward',
            //     'remarks' => 'New Application',
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s')
            // );
            // $insert1 = ApprovalLogs::create($data1);
            \DB::commit();

            Flash::success('Application saved successfully.');
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
