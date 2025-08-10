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
    public function index(Request $request)
    {

        $leaves = Leave::select('leaves.*', 'users.name_bn as user_name')
            ->join('users', 'leaves.employee_id', '=', 'users.id')
            ->where('users.id', Auth::user()->id)
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
        $userId = Auth::user()->id;
        $leaves = Leave::select( 'leave_user_transfers.*', 'leaves.*','leaves.id as leave_id', 'users.department','users.name_bn')
        ->join('leave_user_transfers', 'leave_user_transfers.leave_id', '=', 'leaves.id')
        ->join('users', 'leaves.employee_id', '=', 'users.id')
        ->where('leave_user_transfers.user_id', $userId)->get();
    //   dd($leaves);
        return view('leaves.leave_apply_list')->with('leaves', $leaves);
    }
    public function leaveApprovedRejectedList(Request $request)
    {
        $userId = Auth::user()->id;
        $leaves = Leave::select('leaves.*','leaves.id as leave_id', 'users.department','users.name_bn')
        ->join('users', 'leaves.employee_id', '=', 'users.id')
        ->where('leaves.dpt_head_id', $userId)->get();

        $leave_md = Leave::select('leaves.*','leaves.id as leave_id', 'users.department','users.name_bn', 'userss.name_bn as user_name')
                                ->join('users', 'leaves.employee_id', '=', 'users.id')
                                ->join('users as userss', 'leaves.dpt_head_id', '=', 'userss.id')
                                ->get();

        // dd($leave_md);
        return view('leaves.leave_approved_rejected_list',['leaves'=> $leaves, 'leave_md' => $leave_md]);
    }
    public function getEmpByDept(Request $request)
    {
        $get_leave = Leave::find($request->id);

        // dd($get_leave);
        if (!$get_leave) {
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');
            return redirect()->back();
        }else{
            $get_emp_by_dept = User::where('department', $get_leave->dpt_id)->where('id', '!=', $get_leave->employee_id)->get()->all();
        }
        $data   = [
            'get_emp_by_dept' => $get_emp_by_dept,
            'leave_id' => $get_leave->id,
        ];
        return $data;
    }


    public function create()
    {
        return view('leaves.create');
    }


    public function store(CreateLeaveRequest $request)
    {
     // Validate input
        $validated = $request->validate([
            'from_date'   => 'required',
            'to_date'     => 'required',
            'leave_type'  => 'required',
        ]);

        $input = $request->all();

        // Default to current user if none passed
        if (empty($input['employee_id'])) {
            $input['employee_id'] = auth()->id();
            $input['dpt_id'] = auth()->user()->department;
        }

        // Parse dates using Carbon
        $from = Carbon::createFromFormat('d-m-Y', $input['from_date'])->startOfDay();
        $to   = Carbon::createFromFormat('d-m-Y', $input['to_date'])->endOfDay();

        // Check for overlapping leave
        $overlap = Leave::where('employee_id', $input['employee_id'])
            ->where(function($q) use ($from, $to) {
                $q->whereBetween('from_date', [$from, $to])
                ->orWhereBetween('to_date', [$from, $to])
                ->orWhere(function($q2) use ($from, $to) {
                    $q2->where('from_date', '<=', $from)
                        ->where('to_date',   '>=', $to);
                });
            })->exists();

        if ($overlap) {
            Flash::error('দুঃখিত, এই সময়ের মধ্যে ইতিমধ্যে ছুটি রেজিস্ট্রেশন করা আছে।');
            return redirect()->back()->withInput();
        }

        // Begin transaction
        DB::beginTransaction();
        try {
            // Fill approved fields
            $input['approved_from_date'] = $from->toDateString();
            $input['approved_to_date']   = $to->toDateString();
            $input['approved_total_day'] = $input['total_day'];
            $input['approver_id']        = null;

            // Create leave
            $leave = Leave::create($input);
            DB::commit();
            Flash::success('ছুটি সফলভাবে সংরক্ষিত হয়েছে');
            return redirect()->route('leaves.index');
        } catch (\Exception $e) {
            DB::rollback();
            Flash::error('সিস্টেমে একটি সমস্যা হয়েছে: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }


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


    public function edit($id)
    {
        /** @var Leave $leave */
        $leave = Leave::find($id);

        if (empty($leave)) {
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');

            return redirect(route('leaves.index'));
        }
        $leave->to_date = date('Y-m-d', strtotime($leave->to_date));
        $leave->from_date = date('Y-m-d', strtotime($leave->from_date));

        // dd($leave);

        return view('leaves.edit')->with('leave', $leave);
    }


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
        $input['approved_to_date']   = $input['to_date'];
        $input['approved_total_day'] = $input['total_day'];
        $input['leave_type']         = $input['leave_type'];
        $input['dpt_head_id']        = Auth::user()->id == $leave->employee_id ? null : Auth::user()->id;

        $leave->fill($input);
        $leave->save();

        Flash::success('ছুটি সফলভাবে আপডেট হয়েছে');

        return redirect()->route('leaves.index');
    }


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
        return redirect()->back();
        // }
    }

    public function forwardToDeptEmp(Request  $request)
    {

        // dd($request->all());
        $empArray = explode(',', $request->emp_ids);

        foreach ($empArray as $userId) {
            $leaveUserTransfer = new LeaveUserTransfer();
            $leaveUserTransfer->leave_id = $request->leave_id;
            $leaveUserTransfer->user_id = $userId;
            $leaveUserTransfer->save();
        }
        if($leaveUserTransfer) {
            $leave = Leave::find($request->leave_id);
            if (!$leave) {
                Flash::error('ছুটি খুঁজে পাওয়া যায়নি');
                return redirect()->back();
            }else{
                $leave->status = 1;
                $leave->save();
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'কর্মচারীদের সফলভাবে প্রেরণ করা হয়েছে।'
        ]);
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
            $leave->dpt_head_id = Auth::user()->id;
            $leave->save();
        }
        Flash::success('ছুটি সফলভাবে MD\'র কাছে প্রেরণ করা হয়েছে');
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
            $leave->dpt_head_id = Auth::user()->id;
            $leave->save();

            if ($leave && $leave->id) {
                LeaveUserTransfer::where('leave_id', $leave->id)->delete();
            }
        }
        Flash::success('ছুটি সফলভাবে অনুমোদন করা হয়েছে');
        return redirect()->back();
    }
    public function leaveRejected($id)
    {
        $leave = Leave::find($id);
        if (!$leave) {
            Flash::error('ছুটি খুঁজে পাওয়া যায়নি');
            return redirect()->back();
        }else{
            $leave->status = 4;
            $leave->dpt_head_id = Auth::user()->id;
            $leave->save();

            if ($leave && $leave->id) {
                LeaveUserTransfer::where('leave_id', $leave->id)->delete();
            }
        }
        Flash::success('ছুটি সফলভাবে বাতিল করা হয়েছে');
       return redirect()->back();
    }
}
