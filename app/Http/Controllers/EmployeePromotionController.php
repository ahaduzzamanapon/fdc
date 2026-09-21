<?php

namespace App\Http\Controllers;

use App\Models\EmployeePromotion;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Flash;

class EmployeePromotionController extends Controller
{
    /**
     * Display a listing of employee promotion and increment records.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = EmployeePromotion::with(['user', 'departmentInfo', 'designationInfo', 'creator'])
            ->orderBy('id', 'desc');

        if (who('staff')) {
            $query->where('user_id', Auth::id());
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('change_type')) {
            $query->where('change_type', $request->change_type);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $promotions = $query->paginate(20);

        $users = User::orderBy('name_bn', 'asc')->pluck('name_bn', 'id')->toArray();
        $departments = Department::pluck('name_bn', 'id')->toArray();

        return view('employee_promotions.index', compact('promotions', 'users', 'departments'));
    }

    /**
     * Show the form for creating a new promotion or increment record.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('name_bn', 'asc')->pluck('name_bn', 'id')->prepend('কর্মকর্তা / কর্মচারী নির্বাচন করুন', '')->toArray();
        $departments = Department::pluck('name_bn', 'id')->prepend('ডিপার্টমেন্ট নির্বাচন করুন', '')->toArray();
        $designations = Designation::pluck('desi_name', 'id')->prepend('পদবী নির্বাচন করুন', '')->toArray();

        return view('employee_promotions.create', compact('users', 'departments', 'designations'));
    }

    /**
     * Store a newly created promotion / increment record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'change_type' => 'required|string',
            'effect_month' => 'required|string',
            'basic_salary' => 'required|numeric',
        ], [
            'user_id.required' => 'কর্মকর্তা / কর্মচারী নির্বাচন করুন।',
            'change_type.required' => 'পরিবর্তনের ধরণ নির্বাচন করুন।',
            'effect_month.required' => 'কার্যকরী মাস / তারিখ প্রদান করুন।',
            'basic_salary.required' => 'বেসিক বেতন প্রদান করুন।',
        ]);

        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['created_by'] = Auth::id() ?? 1;

            if ($request->filled('created_at_custom')) {
                $input['created_at'] = $request->created_at_custom;
            }

            $promotion = EmployeePromotion::create($input);

            // Synchronize with User's current profile if update_profile checkbox is checked or default
            if ($request->input('update_user_profile', '1') == '1') {
                $user = User::find($request->user_id);
                if ($user) {
                    if ($request->filled('department_id')) {
                        $user->department = $request->department_id;
                    }
                    if ($request->filled('designation_id')) {
                        $user->designation = $request->designation_id;
                    }
                    if ($request->filled('staff_class')) {
                        $user->staff_class = $request->staff_class;
                    }
                    if ($request->filled('grade')) {
                        $user->grade = $request->grade;
                    }
                    if ($request->filled('basic_salary')) {
                        $user->basic_salary = $request->basic_salary;
                    }
                    $user->save();
                }
            }

            DB::commit();
            Flash::success('ইনক্রিমেন্ট/পদোন্নতি রেকর্ড সফলভাবে সংরক্ষিত হয়েছে।');
            return redirect(route('employeePromotions.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('রেকর্ড সংরক্ষণ করতে ব্যর্থ হয়েছে: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified promotion / increment record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promotion = EmployeePromotion::with(['user', 'departmentInfo', 'designationInfo', 'creator'])->find($id);

        if (empty($promotion)) {
            Flash::error('রেকর্ডটি পাওয়া যায়নি।');
            return redirect(route('employeePromotions.index'));
        }

        return view('employee_promotions.show', compact('promotion'));
    }

    /**
     * Display the full career timeline for a specific employee.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function timeline($user_id)
    {
        if (who('staff')) {
            $user_id = Auth::id();
        }

        $user = User::with(['designationInfo'])->find($user_id);

        if (empty($user)) {
            Flash::error('ব্যবহারকারী পাওয়া যায়নি।');
            return redirect(route('employeePromotions.index'));
        }

        $history = EmployeePromotion::with(['departmentInfo', 'designationInfo'])
            ->where('user_id', $user_id)
            ->orderBy('effect_month', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('employee_promotions.timeline', compact('user', 'history'));
    }

    /**
     * Show the form for editing the specified promotion / increment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $promotion = EmployeePromotion::find($id);

        if (empty($promotion)) {
            Flash::error('রেকর্ডটি পাওয়া যায়নি।');
            return redirect(route('employeePromotions.index'));
        }

        $users = User::orderBy('name_bn', 'asc')->pluck('name_bn', 'id')->prepend('কর্মকর্তা / কর্মচারী নির্বাচন করুন', '')->toArray();
        $departments = Department::pluck('name_bn', 'id')->prepend('ডিপার্টমেন্ট নির্বাচন করুন', '')->toArray();
        $designations = Designation::pluck('desi_name', 'id')->prepend('পদবী নির্বাচন করুন', '')->toArray();

        return view('employee_promotions.edit', compact('promotion', 'users', 'departments', 'designations'));
    }

    /**
     * Update the specified promotion / increment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $promotion = EmployeePromotion::find($id);

        if (empty($promotion)) {
            Flash::error('রেকর্ডটি পাওয়া যায়নি।');
            return redirect(route('employeePromotions.index'));
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'change_type' => 'required|string',
            'effect_month' => 'required|string',
            'basic_salary' => 'required|numeric',
        ]);

        $input = $request->all();
        if ($request->filled('created_at_custom')) {
            $input['created_at'] = $request->created_at_custom;
        }

        $promotion->fill($input);
        $promotion->save();

        Flash::success('রেকর্ড সফলভাবে হালনাগাদ করা হয়েছে।');
        return redirect(route('employeePromotions.index'));
    }

    /**
     * Remove the specified promotion / increment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promotion = EmployeePromotion::find($id);

        if (empty($promotion)) {
            Flash::error('রেকর্ডটি পাওয়া যায়নি।');
            return redirect(route('employeePromotions.index'));
        }

        $promotion->delete();

        Flash::success('রেকর্ড সফলভাবে মুছে ফেলা হয়েছে।');
        return redirect(route('employeePromotions.index'));
    }

    /**
     * AJAX endpoint to fetch a user's current official details.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserInfo(Request $request)
    {
        $userId = $request->get('user_id');
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['success' => false], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'employee_type' => $user->employee_type,
                'join_date'     => $user->join_date,
                'department_id' => $user->department,
                'designation_id'=> $user->designation,
                'staff_class'   => $user->staff_class,
                'grade'         => $user->grade,
                'basic_salary'  => $user->basic_salary,
            ]
        ]);
    }
}
