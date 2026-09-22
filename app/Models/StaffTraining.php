<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffTraining extends Model
{
    use HasFactory;

    protected $table = 'staff_trainings';

    protected $fillable = [
        'user_id',
        'training_id',
        'title',
        'start_date',
        'end_date',
        'duration',
        'institute',
        'location',
        'result_grade',
        'certificate_file',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(StaffTrainingCourse::class, 'training_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Display title: course title or custom title.
     */
    public function getCourseTitleAttribute()
    {
        if ($this->course && $this->course->title) {
            return $this->course->title;
        }
        return $this->title ?? 'N/A';
    }
}
