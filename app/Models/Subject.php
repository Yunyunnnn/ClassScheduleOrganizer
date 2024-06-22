<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'subject_code', 'time_from', 'time_to', 'teacher_id', 'days_of_week'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'subject_student', 'subject_code', 'student_id')
                    ->withPivot('approved')
                    ->withTimestamps();
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'subject_code');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'subject_code');
    }


}
