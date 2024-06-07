<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeControllerTeacher extends Controller
{
    public function teacherindex()
    {
        return view('Teachers.home'); // Ensure this view exists
    }
}
