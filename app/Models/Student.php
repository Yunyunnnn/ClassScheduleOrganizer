<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
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
    ];

    public static function generateStudentId()
    {
        // Implement your logic to generate a unique student_id
        return (string) \Str::uuid();
    }
}


