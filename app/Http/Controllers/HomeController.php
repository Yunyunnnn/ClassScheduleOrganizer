<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
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

    public function dashboard()
    {
        $student = auth()->user();

        // Retrieve enrolled subjects where the student is approved, with schedules
        $enrolledSubjects = $student->subjects()
                                    ->wherePivot('approved', 1) // Only approved enrollments
                                    ->with(['teacher', 'schedules' => function ($query) use ($student) {
                                        $query->whereHas('students', function ($subQuery) use ($student) {
                                            $subQuery->where('students.student_id', $student->student_id); // Qualify with table name or alias
                                        });
                                    }])
                                    ->get();

        return view('Students.dashboard', compact('enrolledSubjects'));
    }

    public function leaveSubject(Request $request)
    {
        $validatedData = $request->validate([
            'subject_code' => 'required|string',
        ]);

        $student = auth()->user();
        $subjectCode = $validatedData['subject_code'];

        // Detach the subject from the student and delete the pivot record
        DB::table('student_subject')
            ->where('student_id', $student->student_id)
            ->where('subject_code', $subjectCode)
            ->delete();

        return redirect()->back()->with('success', 'You have successfully left the subject.');
    }


}
