<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $primaryKey = 'subject_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'subject_code', 'time_from', 'time_to', 'teacher_id', 'days_of_week','room',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'subject_code');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'subject_code');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_subject', 'subject_code', 'student_id')
                    ->withPivot('approved')
                    ->withTimestamps();
    }

    public function isEnrolledByUser($student)
    {
        return $this->students()->where('student_subject.student_id', $student->student_id)->exists();
    }

    public function isEnrollmentApproved($student)
    {
        return $this->students()->where('student_subject.student_id', $student->student_id)->wherePivot('approved', true)->exists();
    }


}
