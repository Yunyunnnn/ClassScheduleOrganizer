<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;

class StudentEnrollmentController extends Controller
{
    public function enroll(Request $request)
    {
        $student = auth()->user();

        $request->validate([
            'subject_code' => 'required|exists:subjects,subject_code',
        ]);

        $subjectCode = $request->input('subject_code');
        $subject = Subject::where('subject_code', $subjectCode)->firstOrFail();

        if ($student->isEnrolledInSubject($subject)) {
            return redirect()->back()->with('warning', 'You are already enrolled in this subject.');
        }

        $student->subjects()->attach($subject->subject_code, ['approved' => false]);

        return redirect()->back()->with('success', 'Enrollment request submitted. Waiting for approval.');
    }

    public function manageStudents()
    {
        $teacher = auth()->user();

        if ($teacher instanceof Teacher) {
            $subjects = $teacher->subjects()->with('students')->get();
        } else {
            $subjects = collect();
        }

        return view('teachers.index', compact('subjects'));
    }

    public function approveStudent(Subject $subject, Student $student)
    {
        $subject->students()->updateExistingPivot($student->student_id, ['approved' => true]);

        return redirect()->back()->with('success', 'Student enrollment approved.');
    }

    public function rejectStudent(Subject $subject, Student $student)
    {
        $subject->students()->detach($student->student_id);

        return redirect()->back()->with('success', 'Student enrollment rejected.');
    }
}

