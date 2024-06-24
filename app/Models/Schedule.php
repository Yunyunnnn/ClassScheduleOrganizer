<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_code',
        'course',
        'block_number',
        'year_level',
        'time_from',
        'time_to',
        'days_of_week',
        'room',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_code', 'subject_code');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_subject', 'schedule_id', 'student_id')
                    ->withPivot('approved')
                    ->withTimestamps();
    }
}

