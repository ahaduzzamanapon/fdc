<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Leave;
use App\Models\LeaveUserTransfer;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;
use Flash;
use Auth;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $data = [
            'leaves'=> $leaves,
            'total_leaves'=>LeaveType::all(),
            'sl_leaves'=>Leave::selectRaw('sum(total_day) as total_days')->where('leave_type', 1)->where('status',3)->where('employee_id',Auth::user()->id)->get(),
            'cl_leaves'=>Leave::selectRaw('sum(total_day) as total_days')->where('leave_type', 2)->where('status',3)->where('employee_id',Auth::user()->id)->get(),
        ];
        // dd($data['sl_leaves'][0]->total_days);
        return view('leaves.index',$data);
    }
    public function applyLeaveList(Request $request)
    {

        $leaves = Leave::select('leaves.*','leaves.id as leave_id', 'users.*')->join('users', 'leaves.employee_id', '=', 'users.id')->get();
        return view('leaves.leave_apply_list')->with('leaves', $leaves);
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

        // default to current user if none passed
        if (empty($input['employee_id'])) {
            $input['employee_id'] = auth()->id();
            $input['dpt_id'] = auth()->user()->department;
        }

        // parse dates through Carbon so you’re guaranteed proper format
        $from = Carbon::createFromFormat('d-m-Y', $input['from_date'])->startOfDay();
        $to   = Carbon::createFromFormat('d-m-Y', $input['to_date'])->endOfDay();


        // 1) does any existing leave for this employee overlap?
        $overlap = Leave::where('employee_id', $input['employee_id'])
            ->where(function($q) use ($from, $to) {
                $q->whereBetween('from_date', [$from, $to])
                  ->orWhereBetween('to_date',   [$from, $to])
                  ->orWhere(function($q2) use ($from, $to) {
                    $q2->where('from_date', '<=', $from)
                    ->where('to_date',   '>=', $to);
                  });
            })->exists();

        if ($overlap) {
            Flash::error('দুঃখিত, এই সময়ের মধ্যে ইতিমধ্যে ছুটি রেজিস্ট্রেশন করা আছে।');
            return redirect()->back();
        }

        // 2) if no overlap, fill in your approved_* fields and create
        $input['approved_from_date'] = $from->toDateString();
        $input['approved_to_date']   = $to->toDateString();
        $input['approved_total_day'] = $input['total_day'];
        $input['leave_type']         = $input['leave_type'];
        $input['approver_id']        = null;

        $leave = Leave::create($input);
        Flash::success('ছুটি সফলভাবে সংরক্ষিত হয়েছে');
        return redirect()->route('leaves.index');

        DB::beginTransaction();
        try {
            if (!empty($leave)) {
                $data = array(
                    'leave_id' => $leave->id,
                    'user_id' => $leave->employee_id
                );
                LeaveUserTransfer::create($data);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Flash::error('Failed to Insert: ' . $e->getMessage());
            return back()->with('error', 'Failed to Insert: ' . $e->getMessage());
        }
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
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');

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
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');

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
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');
            return redirect(route('leaves.index'));
        }
        $input['approved_from_date'] = $input['from_date'];
        $input['approved_to_date'] = $input['to_date'];
        $input['approved_total_day'] = $input['total_day'];
        $input['leave_type']         = $input['leave_type'];

        $leave->fill($input);
        $leave->save();

        Flash::success('ছুটি সফলভাবে আপডেট হয়েছে');

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
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');
            return redirect(route('leaves.index'));
        }
        $leave->delete();
        Flash::success('ছুটি সফলভাবে ডিলিট হয়েছে');
        if(in_aarray(Auth::user()->user_role,[5,6,7,8,9,10])){
            return redirect(route('leaves.apply.leave.list'));
        }else{
            return redirect(route('leaves.index'));
        }

    }

    public function forwardToDeptHead($id)
    {
        $leave = Leave::find($id);
        // dd($leave);
        if (!$leave) {
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');
            return redirect()->back();
        }else{
            $leave->status = 1;
            $leave->save();
        }
        Flash::success('ছুটি সফলভাবে বিভাগীয় প্রধানের কাছে প্রেরণ করা হয়েছে');
        return redirect()->route('leaves.index');
    }

    public function forwardToMd($id)
    {
        // dd($id);
        $leave = Leave::find($id);

        if (!$leave) {
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');
            return redirect()->back();
        }else{
            $leave->status = 2;
            $leave->save();
        }
        Flash::success('ছুটি সফলভাবে MD\'র কাছে প্রেরণ করা হয়েছে');
        return redirect()->route('leaves.apply.leave.list');
    }
    public function forwardToDirectorFinance($id)
    {
        $leave = Leave::find($id);
        if (!$leave) {
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');
            return redirect()->back();
        }else{
            $leave->status = 2 ;
            $leave->save();
        }
        Flash::success('ছুটি সফলভাবে ফিন্যান্স ডিরেক্টরের কাছে প্রেরণ করা হয়েছে');
        return redirect()->route('leaves.apply.leave.list');
    }


    public function leaveApproved($id)
    {
        $leave = Leave::find($id);
        if (!$leave) {
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');
            return redirect()->back();
        }else{
            $leave->status = 3;
            $leave->save();
        }
        Flash::success('ছুটি সফলভাবে অনুমোদন করা হয়েছে');
        return redirect()->route('leaves.apply.leave.list');
    }
    public function leaveRejected($id)
    {
        $leave = Leave::find($id);
        if (!$leave) {
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');
            return redirect()->back();
        }else{
            $leave->status = 4;
            $leave->save();
        }
        Flash::success('ছুটি সফলভাবে বাতিল করা হয়েছে');
        return redirect()->route('leaves.apply.leave.list');
    }
}
