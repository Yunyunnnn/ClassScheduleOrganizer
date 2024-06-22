<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticatableStudent;
use Illuminate\Database\Eloquent\Model;

class Student extends AuthenticatableStudent
{
    use HasFactory;

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

    public static function generateStudentId()
    {
        return (string) \Str::uuid();
    }

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

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_student', 'student_id', 'subject_code')
                    ->withPivot('approved')
                    ->withTimestamps();
    }
}
