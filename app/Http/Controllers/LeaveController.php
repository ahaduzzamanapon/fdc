<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Leave;
use Illuminate\Http\Request;
use Flash;
use Response;

class LeaveController extends AppBaseController
{
    /**
     * Display a listing of the Leave.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Leave $leaves */
        $leaves = Leave::select('leaves.*', 'users.name_bn as user_name')
            ->join('users', 'leaves.employee_id', '=', 'users.id')
            ->get();
        return view('leaves.index')
            ->with('leaves', $leaves);
    }

    /**
     * Show the form for creating a new Leave.
     *
     * @return Response
     */
    public function create()
    {
        return view('leaves.create');
    }

    /**
     * Store a newly created Leave in storage.
     *
     * @param CreateLeaveRequest $request
     *
     * @return Response
     */
    public function store(CreateLeaveRequest $request)
    {
        $input = $request->all();
        $input['approved_from_date'] = $input['from_date'];
        $input['approved_to_date'] = $input['to_date'];
        $input['approved_total_day'] = $input['total_day'];
        $input['approver_id'] = null;

        /** @var Leave $leave */
        $leave = Leave::create($input);

        Flash::success('ছুটি সফলভাবে সংরক্ষিত হয়েছে।');

        return redirect(route('leaves.index'));
    }

    /**
     * Display the specified Leave.
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
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি।');

            return redirect(route('leaves.index'));
        }

        return view('leaves.show')->with('leave', $leave);
    }

    /**
     * Show the form for editing the specified Leave.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Leave $leave */
        $leave = Leave::find($id);

        if (empty($leave)) {
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি।');

            return redirect(route('leaves.index'));
        }

        return view('leaves.edit')->with('leave', $leave);
    }

    /**
     * Update the specified Leave in storage.
     *
     * @param int $id
     * @param UpdateLeaveRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLeaveRequest $request)
    {
        /** @var Leave $leave */
        $leave = Leave::find($id);
        $input = $request->all();

        if (empty($leave)) {
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি।');
            return redirect(route('leaves.index'));
        }
        $input['approved_from_date'] = $input['from_date'];
        $input['approved_to_date'] = $input['to_date'];
        $input['approved_total_day'] = $input['total_day'];

        $leave->fill($input);
        $leave->save();

        Flash::success('ছুটি সফলভাবে আপডেট হয়েছে।');

        return redirect(route('leaves.index'));
    }

    /**
     * Remove the specified Leave from storage.
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
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি।');
            return redirect(route('leaves.index'));
        }
        $leave->delete();
        Flash::success('ছুটি সফলভাবে ডিলিট হয়েছে।');
        return redirect(route('leaves.index'));
    }
}
