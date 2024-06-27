<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'subject_id', 'status'];

    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }
}
