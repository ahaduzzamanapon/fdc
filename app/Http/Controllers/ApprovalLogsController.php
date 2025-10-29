<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateApprovalLogsRequest;
use App\Http\Requests\UpdateApprovalLogsRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ApprovalLogs;
use Illuminate\Http\Request;
use Flash;
use Response;

class ApprovalLogsController extends AppBaseController
{
    /**
     * Display a listing of the ApprovalLogs.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var ApprovalLogs $approvalLogs */
        $approvalLogs = ApprovalLogs::paginate(10);

        return view('approval_logs.index')
            ->with('approvalLogs', $approvalLogs);
    }

    /**
     * Show the form for creating a new ApprovalLogs.
     *
     * @return Response
     */
    public function create()
    {
        return view('approval_logs.create');
    }

    /**
     * Store a newly created ApprovalLogs in storage.
     *
     * @param CreateApprovalLogsRequest $request
     *
     * @return Response
     */
    public function store(CreateApprovalLogsRequest $request)
    {
        $input = $request->all();

        /** @var ApprovalLogs $approvalLogs */
        $approvalLogs = ApprovalLogs::create($input);

        Flash::success('Approval Logs saved successfully.');

        return redirect(route('approvalLogs.index'));
    }

    /**
     * Display the specified ApprovalLogs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ApprovalLogs $approvalLogs */
        $approvalLogs = ApprovalLogs::find($id);

        if (empty($approvalLogs)) {
            Flash::error('Approval Logs not found');

            return redirect(route('approvalLogs.index'));
        }

        return view('approval_logs.show')->with('approvalLogs', $approvalLogs);
    }

    /**
     * Show the form for editing the specified ApprovalLogs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ApprovalLogs $approvalLogs */
        $approvalLogs = ApprovalLogs::find($id);

        if (empty($approvalLogs)) {
            Flash::error('Approval Logs not found');

            return redirect(route('approvalLogs.index'));
        }

        return view('approval_logs.edit')->with('approvalLogs', $approvalLogs);
    }

    /**
     * Update the specified ApprovalLogs in storage.
     *
     * @param int $id
     * @param UpdateApprovalLogsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApprovalLogsRequest $request)
    {
        /** @var ApprovalLogs $approvalLogs */
        $approvalLogs = ApprovalLogs::find($id);

        if (empty($approvalLogs)) {
            Flash::error('Approval Logs not found');

            return redirect(route('approvalLogs.index'));
        }

        $approvalLogs->fill($request->all());
        $approvalLogs->save();

        Flash::success('Approval Logs updated successfully.');

        return redirect(route('approvalLogs.index'));
    }

    /**
     * Remove the specified ApprovalLogs from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ApprovalLogs $approvalLogs */
        $approvalLogs = ApprovalLogs::find($id);

        if (empty($approvalLogs)) {
            Flash::error('Approval Logs not found');

            return redirect(route('approvalLogs.index'));
        }

        $approvalLogs->delete();

        Flash::success('Approval Logs deleted successfully.');

        return redirect(route('approvalLogs.index'));
    }
}
