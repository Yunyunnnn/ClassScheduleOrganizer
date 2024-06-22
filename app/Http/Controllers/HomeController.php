<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function studentHome()
    {
        return view('Students.home')->with('approved', auth()->user()->approved);
    }

    public function teacherHome()
    {
        $approved = auth()->user()->approved;
        $subjects = Subject::where('teacher_id', auth()->id())->get();

        return view('Teachers.home', [
            'subjects' => $subjects,
            'approved' => $approved,
            'approval_message_dismissed' => session('approval_message_dismissed', false)
        ]);
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

    public function dismissApprovalMessage()
    {
        session(['approval_message_dismissed' => true]);
        return response()->json(['status' => 'success']);
    }

    public function showHomePage()
    {
        if
        (auth()->user()->approved) {
        return view('Students.home');
    }
    else
        {
        return view('Students.home')->with('approvalPending', true);
        }
    }



}
