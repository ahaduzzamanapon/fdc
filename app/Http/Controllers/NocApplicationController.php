<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noc;
use App\Models\ApprovalFlowMaster;
use App\Models\ApprovalFlowSteps;
use App\Models\ApprovalRequests;
use App\Models\ApprovalLogs;

class NocApplicationController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    // NOC Application pending list
    public function pending()
    {
        $nocs = Noc::where('status', 'pending')->get();
        return view('noc.pending_list', compact('nocs'));
    }

    // NOC Application approved list
    public function approved()
    {
        $nocs = Noc::where('status', 'approved')->get();
        return view('noc.approved_list', compact('nocs'));
    }

    // NOC Application rejected list
    public function rejected()
    {
        $nocs = Noc::where('status', 'rejected')->get();
        return view('noc.rejected_list', compact('nocs'));
    }

    // NOC Application forward
    public function forward($noc)
    {
        $noc = Noc::find($noc);
        return view('noc.forward')->with('noc', $noc);
    }

    // NOC Application update status
    public function update_status(Request $request)
    {
        $noc = Noc::find($request->noc_id);
        if (!$noc) {
            return redirect()
                ->route('nocApplication.pending')
                ->with('error', 'NOC not found');
        }

        $noc->status = $request->status;
        $noc->save();

        return redirect()
            ->route('nocApplication.pending')
            ->with('success', 'Status updated successfully');
    }
}
