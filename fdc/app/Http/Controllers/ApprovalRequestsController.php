<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateApprovalRequestsRequest;
use App\Http\Requests\UpdateApprovalRequestsRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ApprovalRequests;
use Illuminate\Http\Request;
use Flash;
use Response;

class ApprovalRequestsController extends AppBaseController
{
    /**
     * Display a listing of the ApprovalRequests.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var ApprovalRequests $approvalRequests */
        $approvalRequests = ApprovalRequests::paginate(10);

        return view('approval_requests.index')
            ->with('approvalRequests', $approvalRequests);
    }

    /**
     * Show the form for creating a new ApprovalRequests.
     *
     * @return Response
     */
    public function create()
    {
        return view('approval_requests.create');
    }

    /**
     * Store a newly created ApprovalRequests in storage.
     *
     * @param CreateApprovalRequestsRequest $request
     *
     * @return Response
     */
    public function store(CreateApprovalRequestsRequest $request)
    {
        $input = $request->all();

        /** @var ApprovalRequests $approvalRequests */
        $approvalRequests = ApprovalRequests::create($input);

        Flash::success('Approval Requests saved successfully.');

        return redirect(route('approvalRequests.index'));
    }

    /**
     * Display the specified ApprovalRequests.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ApprovalRequests $approvalRequests */
        $approvalRequests = ApprovalRequests::find($id);

        if (empty($approvalRequests)) {
            Flash::error('Approval Requests not found');

            return redirect(route('approvalRequests.index'));
        }

        return view('approval_requests.show')->with('approvalRequests', $approvalRequests);
    }

    /**
     * Show the form for editing the specified ApprovalRequests.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ApprovalRequests $approvalRequests */
        $approvalRequests = ApprovalRequests::find($id);

        if (empty($approvalRequests)) {
            Flash::error('Approval Requests not found');

            return redirect(route('approvalRequests.index'));
        }

        return view('approval_requests.edit')->with('approvalRequests', $approvalRequests);
    }

    /**
     * Update the specified ApprovalRequests in storage.
     *
     * @param int $id
     * @param UpdateApprovalRequestsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApprovalRequestsRequest $request)
    {
        /** @var ApprovalRequests $approvalRequests */
        $approvalRequests = ApprovalRequests::find($id);

        if (empty($approvalRequests)) {
            Flash::error('Approval Requests not found');

            return redirect(route('approvalRequests.index'));
        }

        $approvalRequests->fill($request->all());
        $approvalRequests->save();

        Flash::success('Approval Requests updated successfully.');

        return redirect(route('approvalRequests.index'));
    }

    /**
     * Remove the specified ApprovalRequests from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ApprovalRequests $approvalRequests */
        $approvalRequests = ApprovalRequests::find($id);

        if (empty($approvalRequests)) {
            Flash::error('Approval Requests not found');

            return redirect(route('approvalRequests.index'));
        }

        $approvalRequests->delete();

        Flash::success('Approval Requests deleted successfully.');

        return redirect(route('approvalRequests.index'));
    }
}
