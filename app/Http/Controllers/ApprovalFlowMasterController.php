<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateApprovalFlowMasterRequest;
use App\Http\Requests\UpdateApprovalFlowMasterRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ApprovalFlowMaster;
use Illuminate\Http\Request;
use Flash;
use Response;

class ApprovalFlowMasterController extends AppBaseController
{
    /**
     * Display a listing of the ApprovalFlowMaster.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var ApprovalFlowMaster $approvalFlowMasters */
        $approvalFlowMasters = ApprovalFlowMaster::paginate(10);

        return view('approval_flow_masters.index')
            ->with('approvalFlowMasters', $approvalFlowMasters);
    }

    /**
     * Show the form for creating a new ApprovalFlowMaster.
     *
     * @return Response
     */
    public function create()
    {
        return view('approval_flow_masters.create');
    }

    /**
     * Store a newly created ApprovalFlowMaster in storage.
     *
     * @param CreateApprovalFlowMasterRequest $request
     *
     * @return Response
     */
    public function store(CreateApprovalFlowMasterRequest $request)
    {
        $input = $request->all();

        /** @var ApprovalFlowMaster $approvalFlowMaster */
        $approvalFlowMaster = ApprovalFlowMaster::create($input);

        Flash::success('Approval Flow Master saved successfully.');

        return redirect(route('approvalFlowMasters.index'));
    }

    /**
     * Display the specified ApprovalFlowMaster.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ApprovalFlowMaster $approvalFlowMaster */
        $approvalFlowMaster = ApprovalFlowMaster::find($id);

        if (empty($approvalFlowMaster)) {
            Flash::error('Approval Flow Master not found');

            return redirect(route('approvalFlowMasters.index'));
        }

        return view('approval_flow_masters.show')->with('approvalFlowMaster', $approvalFlowMaster);
    }

    /**
     * Show the form for editing the specified ApprovalFlowMaster.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ApprovalFlowMaster $approvalFlowMaster */
        $approvalFlowMaster = ApprovalFlowMaster::find($id);

        if (empty($approvalFlowMaster)) {
            Flash::error('Approval Flow Master not found');

            return redirect(route('approvalFlowMasters.index'));
        }

        return view('approval_flow_masters.edit')->with('approvalFlowMaster', $approvalFlowMaster);
    }

    /**
     * Update the specified ApprovalFlowMaster in storage.
     *
     * @param int $id
     * @param UpdateApprovalFlowMasterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApprovalFlowMasterRequest $request)
    {
        /** @var ApprovalFlowMaster $approvalFlowMaster */
        $approvalFlowMaster = ApprovalFlowMaster::find($id);

        if (empty($approvalFlowMaster)) {
            Flash::error('Approval Flow Master not found');

            return redirect(route('approvalFlowMasters.index'));
        }

        $approvalFlowMaster->fill($request->all());
        $approvalFlowMaster->save();

        Flash::success('Approval Flow Master updated successfully.');

        return redirect(route('approvalFlowMasters.index'));
    }

    /**
     * Remove the specified ApprovalFlowMaster from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ApprovalFlowMaster $approvalFlowMaster */
        $approvalFlowMaster = ApprovalFlowMaster::find($id);

        if (empty($approvalFlowMaster)) {
            Flash::error('Approval Flow Master not found');

            return redirect(route('approvalFlowMasters.index'));
        }

        $approvalFlowMaster->delete();

        Flash::success('Approval Flow Master deleted successfully.');

        return redirect(route('approvalFlowMasters.index'));
    }
}
