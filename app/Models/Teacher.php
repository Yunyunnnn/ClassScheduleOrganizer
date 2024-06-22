<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'middle_initial', 'email', 'password', 'approved',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasManyThrough(Enrollment::class, Subject::class, 'teacher_id', 'subject_code');
    }
}
