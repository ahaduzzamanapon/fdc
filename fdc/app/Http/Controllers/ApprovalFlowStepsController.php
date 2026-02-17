<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateApprovalFlowStepsRequest;
use App\Http\Requests\UpdateApprovalFlowStepsRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ApprovalFlowSteps;
use Illuminate\Http\Request;
use Flash;
use Response;

class ApprovalFlowStepsController extends AppBaseController
{
    /**
     * Display a listing of the ApprovalFlowSteps.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var ApprovalFlowSteps $approvalFlowSteps */
        $approvalFlowSteps = ApprovalFlowSteps::select(
            'approval_flow_steps.*',
            'approval_flow_master.name as flow_name',
            'from_role.name as from_role_name',
            'to_role.name as to_role_name'
        )
        ->join('approval_flow_master', 'approval_flow_master.id', '=', 'approval_flow_steps.flow_id')
        ->leftJoin('roles as from_role', 'from_role.id', '=', 'approval_flow_steps.from_role_id')
        ->leftJoin('roles as to_role', 'to_role.id', '=', 'approval_flow_steps.to_role_id')
        ->orderBy('approval_flow_steps.id', 'desc')
        ->paginate(10);

        return view('approval_flow_steps.index')
            ->with('approvalFlowSteps', $approvalFlowSteps);
    }

    /**
     * Show the form for creating a new ApprovalFlowSteps.
     *
     * @return Response
     */
    public function create()
    {
        return view('approval_flow_steps.create');
    }

    /**
     * Store a newly created ApprovalFlowSteps in storage.
     *
     * @param CreateApprovalFlowStepsRequest $request
     *
     * @return Response
     */
    public function store(CreateApprovalFlowStepsRequest $request)
    {
        $input = $request->all();

        /** @var ApprovalFlowSteps $approvalFlowSteps */
        $approvalFlowSteps = ApprovalFlowSteps::create($input);

        Flash::success('Approval Flow Steps saved successfully.');

        return redirect(route('approvalFlowSteps.index'));
    }

    /**
     * Display the specified ApprovalFlowSteps.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ApprovalFlowSteps $approvalFlowSteps */
        $approvalFlowSteps = ApprovalFlowSteps::select(
            'approval_flow_steps.*',
            'approval_flow_master.name as flow_name',
            'from_role.name as from_role_name',
            'to_role.name as to_role_name'
        )
        ->join('approval_flow_master', 'approval_flow_master.id', '=', 'approval_flow_steps.flow_id')
        ->leftJoin('roles as from_role', 'from_role.id', '=', 'approval_flow_steps.from_role_id')
        ->leftJoin('roles as to_role', 'to_role.id', '=', 'approval_flow_steps.to_role_id')
        ->orderBy('approval_flow_steps.id', 'desc')
        ->find($id);


        if (empty($approvalFlowSteps)) {
            Flash::error('Approval Flow Steps not found');

            return redirect(route('approvalFlowSteps.index'));
        }

        return view('approval_flow_steps.show')->with('approvalFlowSteps', $approvalFlowSteps);
    }

    /**
     * Show the form for editing the specified ApprovalFlowSteps.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ApprovalFlowSteps $approvalFlowSteps */
        $approvalFlowSteps = ApprovalFlowSteps::find($id);

        if (empty($approvalFlowSteps)) {
            Flash::error('Approval Flow Steps not found');

            return redirect(route('approvalFlowSteps.index'));
        }

        return view('approval_flow_steps.edit')->with('approvalFlowSteps', $approvalFlowSteps);
    }

    /**
     * Update the specified ApprovalFlowSteps in storage.
     *
     * @param int $id
     * @param UpdateApprovalFlowStepsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApprovalFlowStepsRequest $request)
    {
        /** @var ApprovalFlowSteps $approvalFlowSteps */
        $approvalFlowSteps = ApprovalFlowSteps::find($id);

        if (empty($approvalFlowSteps)) {
            Flash::error('Approval Flow Steps not found');

            return redirect(route('approvalFlowSteps.index'));
        }

        $approvalFlowSteps->fill($request->all());
        $approvalFlowSteps->save();

        Flash::success('Approval Flow Steps updated successfully.');

        return redirect(route('approvalFlowSteps.index'));
    }

    /**
     * Remove the specified ApprovalFlowSteps from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ApprovalFlowSteps $approvalFlowSteps */
        $approvalFlowSteps = ApprovalFlowSteps::find($id);

        if (empty($approvalFlowSteps)) {
            Flash::error('Approval Flow Steps not found');

            return redirect(route('approvalFlowSteps.index'));
        }

        $approvalFlowSteps->delete();

        Flash::success('Approval Flow Steps deleted successfully.');

        return redirect(route('approvalFlowSteps.index'));
    }
}
