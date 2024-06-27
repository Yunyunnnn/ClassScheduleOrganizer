<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'block_number',
        'approved',
        'year_level',
        'course',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_code')
                    ->withPivot('schedule_id', 'approved')
                    ->withTimestamps();
    }

    public function isEnrolledInSubject(Subject $subject)
    {
        return $this->subjects()->where('student_subject.subject_code', $subject->subject_code)->exists();
    }

    public function isEnrolledInSchedule($scheduleId)
    {
        return $this->subjects()->wherePivot('schedule_id', $scheduleId)->exists();
    }

    public function enrolledSchedules()
    {
        return $this->belongsToMany(Schedule::class, 'student_subject', 'student_id', 'schedule_id')
                    ->withPivot('approved')
                    ->withTimestamps();
    }
}

