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
        return view('Admin.home', [
            'students' => $pendingStudents,
            'teachers' => $pendingTeachers
        ]);
    }

    public function approve($id, $type)
    {
        $type = strtolower($type);
    
        if (!in_array($type, ['student', 'teacher'])) {
            return redirect()->back()->with('error', 'Invalid user type.');
        }
    
        $user = null;
        if ($type == 'student') {
            $user = Student::find($id);
        } elseif ($type == 'teacher') {
            $user = Teacher::find($id);
        }
    
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
    
        $user->approved = true;
        $user->save();
    
        return redirect()->route('admin.home')->with('success', ucfirst($type) . ' approved successfully.');
    }

    public function index()
    {
        return view('Students.home');
    }
}
