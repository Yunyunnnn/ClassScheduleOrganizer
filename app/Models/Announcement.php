<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['subject_code', 'message'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}

