<?php

namespace App\Http\Controllers;

use App\Models\StaffTraining;
use App\Models\StaffTrainingCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Flash;

class StaffTrainingController extends Controller
{
    /**
     * Display a listing of staff training records.
     */
    public function index(Request $request)
    {
        $query = StaffTraining::with(['user', 'course', 'creator'])
            ->orderBy('id', 'desc');

        // Staff members can view their own training records
        if (who('staff')) {
            $query->where('user_id', Auth::id());
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('training_id')) {
            $query->where('training_id', $request->training_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            });
        } elseif ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $trainings = $query->paginate(20);

        $users = User::orderBy('name_bn', 'asc')->pluck('name_bn', 'id')->toArray();
        $courses = StaffTrainingCourse::where('status', true)->pluck('title', 'id')->toArray();

        return view('staff_trainings.index', compact('trainings', 'users', 'courses'));
    }

    /**
     * Show the form for creating a new training record.
     */
    public function create()
    {
        $users = User::orderBy('name_bn', 'asc')->pluck('name_bn', 'id')->prepend('কর্মকর্তা / কর্মচারী নির্বাচন করুন', '')->toArray();
        $courses = StaffTrainingCourse::where('status', true)->pluck('title', 'id')->prepend('প্রশিক্ষণ কোর্স নির্বাচন করুন (ঐচ্ছিক)', '')->toArray();

        return view('staff_trainings.create', compact('users', 'courses'));
    }

    /**
     * Store a newly created training record in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required_without:training_id|nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];

        if (!who('staff')) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules, [
            'user_id.required' => 'কর্মকর্তা / কর্মচারী নির্বাচন করুন।',
            'title.required_without' => 'প্রশিক্ষণ কোর্স নির্বাচন করুন অথবা ট্রেনিংয়ের শিরোনাম প্রদান করুন।',
            'end_date.after_or_equal' => 'সমাপ্তির তারিখ শুরুর তারিখের সমান বা পরবর্তী হতে হবে।',
            'certificate_file.mimes' => 'সনদপত্র অবশ্যই PDF, JPG, JPEG, বা PNG ফরম্যাটে হতে হবে।',
        ]);

        $userId = who('staff') ? Auth::id() : $request->user_id;

        $certificatePath = null;
        if ($request->hasFile('certificate_file')) {
            $certificatePath = uploadFile($request->file('certificate_file'), 'uploads/trainings', 'cert_' . time() . '_' . rand(100, 999));
        }

        // Auto calculate duration if not given
        $duration = $request->duration;
        if (empty($duration) && $request->filled('start_date') && $request->filled('end_date')) {
            $start = \Carbon\Carbon::parse($request->start_date);
            $end = \Carbon\Carbon::parse($request->end_date);
            $days = $start->diffInDays($end) + 1;
            $duration = $days . ' দিন';
        }

        StaffTraining::create([
            'user_id' => $userId,
            'training_id' => $request->training_id ?: null,
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $duration,
            'institute' => $request->institute,
            'location' => $request->location,
            'result_grade' => $request->result_grade,
            'certificate_file' => $certificatePath,
            'remarks' => $request->remarks,
            'created_by' => Auth::id(),
        ]);

        Flash::success('প্রশিক্ষণ তথ্য সফলভাবে সংরক্ষণ করা হয়েছে।');
        return redirect()->route('staffTrainings.index');
    }

    /**
     * Display the specified training record.
     */
    public function show($id)
    {
        $training = StaffTraining::with(['user', 'course', 'creator'])->findOrFail($id);

        if (who('staff') && $training->user_id != Auth::id()) {
            Flash::error('আপনি কেবল আপনার নিজের প্রশিক্ষণ তথ্য দেখতে পারবেন।');
            return redirect()->route('staffTrainings.index');
        }

        return view('staff_trainings.show', compact('training'));
    }

    /**
     * Show the form for editing the specified training record.
     */
    public function edit($id)
    {
        $training = StaffTraining::findOrFail($id);

        if (who('staff') && $training->user_id != Auth::id()) {
            Flash::error('আপনি কেবল আপনার নিজের প্রশিক্ষণ তথ্য সম্পাদনা করতে পারবেন।');
            return redirect()->route('staffTrainings.index');
        }

        $users = User::orderBy('name_bn', 'asc')->pluck('name_bn', 'id')->prepend('কর্মকর্তা / কর্মচারী নির্বাচন করুন', '')->toArray();
        $courses = StaffTrainingCourse::where('status', true)->pluck('title', 'id')->prepend('প্রশিক্ষণ কোর্স নির্বাচন করুন (ঐচ্ছিক)', '')->toArray();

        return view('staff_trainings.edit', compact('training', 'users', 'courses'));
    }

    /**
     * Update the specified training record in storage.
     */
    public function update(Request $request, $id)
    {
        $training = StaffTraining::findOrFail($id);

        if (who('staff') && $training->user_id != Auth::id()) {
            Flash::error('আপনি কেবল আপনার নিজের প্রশিক্ষণ তথ্য সম্পাদনা করতে পারবেন।');
            return redirect()->route('staffTrainings.index');
        }

        $rules = [
            'title' => 'required_without:training_id|nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];

        if (!who('staff')) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        $certificatePath = $training->certificate_file;
        if ($request->hasFile('certificate_file')) {
            $certificatePath = uploadFile($request->file('certificate_file'), 'uploads/trainings', 'cert_' . time() . '_' . rand(100, 999));
        }

        $duration = $request->duration;
        if (empty($duration) && $request->filled('start_date') && $request->filled('end_date')) {
            $start = \Carbon\Carbon::parse($request->start_date);
            $end = \Carbon\Carbon::parse($request->end_date);
            $days = $start->diffInDays($end) + 1;
            $duration = $days . ' দিন';
        }

        $updateData = [
            'training_id' => $request->training_id ?: null,
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $duration,
            'institute' => $request->institute,
            'location' => $request->location,
            'result_grade' => $request->result_grade,
            'certificate_file' => $certificatePath,
            'remarks' => $request->remarks,
        ];

        if (!who('staff')) {
            $updateData['user_id'] = $request->user_id;
        }

        $training->update($updateData);

        Flash::success('প্রশিক্ষণ তথ্য সফলভাবে আপডেট করা হয়েছে।');
        return redirect()->route('staffTrainings.index');
    }

    /**
     * Remove the specified training record from storage.
     */
    public function destroy($id)
    {
        $training = StaffTraining::findOrFail($id);

        if (who('staff') && $training->user_id != Auth::id()) {
            Flash::error('আপনি কেবল আপনার নিজের প্রশিক্ষণ তথ্য মুছতে পারবেন।');
            return redirect()->route('staffTrainings.index');
        }

        $training->delete();

        Flash::success('প্রশিক্ষণ তথ্য সফলভাবে মুছে ফেলা হয়েছে।');
        return redirect()->route('staffTrainings.index');
    }
}
