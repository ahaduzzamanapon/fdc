<?php

namespace App\Http\Controllers;

use App\Models\StaffTrainingCourse;
use Illuminate\Http\Request;
use Flash;

class StaffTrainingCourseController extends Controller
{
    /**
     * Display a listing of training courses.
     */
    public function index(Request $request)
    {
        $courses = StaffTrainingCourse::withCount('staffTrainings')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('staff_training_courses.index', compact('courses'));
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
        ], [
            'title.required' => 'কোর্সের শিরোনাম প্রদান করুন।',
            'type.required' => 'কোর্সের ধরণ নির্বাচন করুন।',
        ]);

        StaffTrainingCourse::create([
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->has('status') ? $request->status : 1,
        ]);

        Flash::success('প্রশিক্ষণ কোর্স সফলভাবে তৈরি করা হয়েছে।');
        return redirect()->route('staffTrainingCourses.index');
    }

    /**
     * Update the specified course.
     */
    public function update(Request $request, $id)
    {
        $course = StaffTrainingCourse::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $course->update([
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->has('status') ? $request->status : $course->status,
        ]);

        Flash::success('প্রশিক্ষণ কোর্স সফলভাবে আপডেট করা হয়েছে।');
        return redirect()->route('staffTrainingCourses.index');
    }

    /**
     * Remove the specified course.
     */
    public function destroy($id)
    {
        $course = StaffTrainingCourse::findOrFail($id);
        $course->delete();

        Flash::success('প্রশিক্ষণ কোর্স সফলভাবে মুছে ফেলা হয়েছে।');
        return redirect()->route('staffTrainingCourses.index');
    }
}
