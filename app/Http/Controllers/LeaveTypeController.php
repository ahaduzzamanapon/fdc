<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeaveTypeRequest;
use App\Http\Requests\UpdateLeaveTypeRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Flash;
use Response;

class LeaveTypeController extends AppBaseController
{
    /**
     * Display a listing of the LeaveType.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var LeaveType $leaveTypes */
        $leaveTypes = LeaveType::all();

        return view('leave_types.index')
            ->with('leaveTypes', $leaveTypes);
    }

    /**
     * Show the form for creating a new LeaveType.
     *
     * @return Response
     */
    public function create()
    {
        return view('leave_types.create');
    }

    /**
     * Store a newly created LeaveType in storage.
     *
     * @param CreateLeaveTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateLeaveTypeRequest $request)
    {
        $input = $request->all();

        /** @var LeaveType $leaveType */
        $leaveType = LeaveType::create($input);

        Flash::success('Leave Type saved successfully.');

        return redirect(route('leaveTypes.index'));
    }

    /**
     * Display the specified LeaveType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LeaveType $leaveType */
        $leaveType = LeaveType::find($id);

        if (empty($leaveType)) {
            Flash::error('Leave Type not found');

            return redirect(route('leaveTypes.index'));
        }

        return view('leave_types.show')->with('leaveType', $leaveType);
    }

    /**
     * Show the form for editing the specified LeaveType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var LeaveType $leaveType */
        $leaveType = LeaveType::find($id);

        if (empty($leaveType)) {
            Flash::error('Leave Type not found');

            return redirect(route('leaveTypes.index'));
        }

        return view('leave_types.edit')->with('leaveType', $leaveType);
    }

    /**
     * Update the specified LeaveType in storage.
     *
     * @param int $id
     * @param UpdateLeaveTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLeaveTypeRequest $request)
    {
        /** @var LeaveType $leaveType */
        $leaveType = LeaveType::find($id);

        if (empty($leaveType)) {
            Flash::error('Leave Type not found');

            return redirect(route('leaveTypes.index'));
        }

        $leaveType->fill($request->all());
        $leaveType->save();

        Flash::success('Leave Type updated successfully.');

        return redirect(route('leaveTypes.index'));
    }

    /**
     * Remove the specified LeaveType from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var LeaveType $leaveType */
        $leaveType = LeaveType::find($id);

        if (empty($leaveType)) {
            Flash::error('Leave Type not found');

            return redirect(route('leaveTypes.index'));
        }

        $leaveType->delete();

        Flash::success('Leave Type deleted successfully.');

        return redirect(route('leaveTypes.index'));
    }
}
