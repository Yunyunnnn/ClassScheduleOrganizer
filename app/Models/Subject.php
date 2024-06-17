<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

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
        return $this->belongsToMany(Student::class, 'subject_student', 'subject_id', 'student_id')
                    ->withTimestamps();
    }

}




