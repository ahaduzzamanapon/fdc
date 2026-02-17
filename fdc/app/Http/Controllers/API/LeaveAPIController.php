<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLeaveAPIRequest;
use App\Http\Requests\API\UpdateLeaveAPIRequest;
use App\Models\Leave;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LeaveResource;
use Response;

/**
 * Class LeaveController
 * @package App\Http\Controllers\API
 */

class LeaveAPIController extends AppBaseController
{
    /**
     * Display a listing of the Leave.
     * GET|HEAD /leaves
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Leave::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $leaves = $query->get();

        return $this->sendResponse(LeaveResource::collection($leaves), 'Leaves retrieved successfully');
    }

    /**
     * Store a newly created Leave in storage.
     * POST /leaves
     *
     * @param CreateLeaveAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLeaveAPIRequest $request)
    {
        $input = $request->all();

        /** @var Leave $leave */
        $leave = Leave::create($input);

        return $this->sendResponse(new LeaveResource($leave), 'Leave saved successfully');
    }

    /**
     * Display the specified Leave.
     * GET|HEAD /leaves/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Leave $leave */
        $leave = Leave::find($id);

        if (empty($leave)) {
            return $this->sendError('Leave not found');
        }

        return $this->sendResponse(new LeaveResource($leave), 'Leave retrieved successfully');
    }

    /**
     * Update the specified Leave in storage.
     * PUT/PATCH /leaves/{id}
     *
     * @param int $id
     * @param UpdateLeaveAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLeaveAPIRequest $request)
    {
        /** @var Leave $leave */
        $leave = Leave::find($id);

        if (empty($leave)) {
            return $this->sendError('Leave not found');
        }

        $leave->fill($request->all());
        $leave->save();

        return $this->sendResponse(new LeaveResource($leave), 'Leave updated successfully');
    }

    /**
     * Remove the specified Leave from storage.
     * DELETE /leaves/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Leave $leave */
        $leave = Leave::find($id);

        if (empty($leave)) {
            return $this->sendError('Leave not found');
        }

        $leave->delete();

        return $this->sendSuccess('Leave deleted successfully');
    }
}
