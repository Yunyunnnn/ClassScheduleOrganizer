<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function studentHome()
    {
        return view('Students.home')->with('approved', auth()->user()->approved);
    }

    public function teacherHome()
    {
        return view('Teachers.home')->with('approved', auth()->user()->approved);
    }

    public function adminHome()
    {
        $pendingStudents = Student::where('approved', false)->get();
        $pendingTeachers = Teacher::where('approved', false)->get();
        $pendingUsers = $pendingStudents->merge($pendingTeachers);
        return view('Admin.home', ['pendingUsers' => $pendingUsers]);
    }

    public function approved($id, $type)
    {
        if ($type == 'Student') {
            $user = Student::find($id);
        } elseif ($type == 'Teacher') {
            $user = Teacher::find($id);
        } else {
            return redirect()->back()->with('error', 'Invalid user type.');
        }

        if ($user) {
            $user->approved = true;
            $user->save();
            return redirect()->route('admin.home')->with('success', "$type approved successfully.");
        }

        return redirect()->back()->with('error', 'User not found.');
    }

    public function index()
    {
        return view('Students.home');
    }
}