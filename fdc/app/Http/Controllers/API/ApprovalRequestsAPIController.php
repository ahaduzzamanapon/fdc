<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateApprovalRequestsAPIRequest;
use App\Http\Requests\API\UpdateApprovalRequestsAPIRequest;
use App\Models\ApprovalRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ApprovalRequestsResource;
use Response;

/**
 * Class ApprovalRequestsController
 * @package App\Http\Controllers\API
 */

class ApprovalRequestsAPIController extends AppBaseController
{
    /**
     * Display a listing of the ApprovalRequests.
     * GET|HEAD /approvalRequests
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ApprovalRequests::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $approvalRequests = $query->get();

        return $this->sendResponse(ApprovalRequestsResource::collection($approvalRequests), 'Approval Requests retrieved successfully');
    }

    /**
     * Store a newly created ApprovalRequests in storage.
     * POST /approvalRequests
     *
     * @param CreateApprovalRequestsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateApprovalRequestsAPIRequest $request)
    {
        $input = $request->all();

        /** @var ApprovalRequests $approvalRequests */
        $approvalRequests = ApprovalRequests::create($input);

        return $this->sendResponse(new ApprovalRequestsResource($approvalRequests), 'Approval Requests saved successfully');
    }

    /**
     * Display the specified ApprovalRequests.
     * GET|HEAD /approvalRequests/{id}
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
            return $this->sendError('Approval Requests not found');
        }

        return $this->sendResponse(new ApprovalRequestsResource($approvalRequests), 'Approval Requests retrieved successfully');
    }

    /**
     * Update the specified ApprovalRequests in storage.
     * PUT/PATCH /approvalRequests/{id}
     *
     * @param int $id
     * @param UpdateApprovalRequestsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApprovalRequestsAPIRequest $request)
    {
        /** @var ApprovalRequests $approvalRequests */
        $approvalRequests = ApprovalRequests::find($id);

        if (empty($approvalRequests)) {
            return $this->sendError('Approval Requests not found');
        }

        $approvalRequests->fill($request->all());
        $approvalRequests->save();

        return $this->sendResponse(new ApprovalRequestsResource($approvalRequests), 'ApprovalRequests updated successfully');
    }

    /**
     * Remove the specified ApprovalRequests from storage.
     * DELETE /approvalRequests/{id}
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
            return $this->sendError('Approval Requests not found');
        }

        $approvalRequests->delete();

        return $this->sendSuccess('Approval Requests deleted successfully');
    }
}
