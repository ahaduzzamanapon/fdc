<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffTrainingCourse extends Model
{
    use HasFactory;

    protected $table = 'staff_training_courses';

    protected $fillable = [
        'title',
        'type',
        'description',
        'status',
    ];

    public function staffTrainings()
    {
        return $this->hasMany(StaffTraining::class, 'training_id');
    }
}
