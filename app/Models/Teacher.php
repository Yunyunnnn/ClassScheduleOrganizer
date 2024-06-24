<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        // Add other fields as needed
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }
}


