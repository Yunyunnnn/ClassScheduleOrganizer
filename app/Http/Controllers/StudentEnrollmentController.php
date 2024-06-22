<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;

class StudentEnrollmentController extends Controller
{
    public function enroll(Request $request, Subject $subject)
    {
        $student = $subject->students();

        if ($student->subjects()->where('subject_code', $subject->subject_code)->exists()) {
            return redirect()->back()->with('warning', 'You are already enrolled in this subject.');
        }

        $student->subjects()->attach($subject);

        return redirect()->back()->with('success', 'You have successfully enrolled in the subject.');
    }

    public function manageStudents()
    {
        $teacher = auth()->user();

        if ($teacher instanceof Teacher) {
            $subjects = $teacher->subjects()->with('students')->get();
        } else {
            $subjects = collect();
        }

        return view('Teachers.index', compact('subjects'));
    }

    public function approveStudent(Subject $subject, Student $student)
    {
        $subject->students()->updateExistingPivot($student->id, ['approved' => true]);

        return redirect()->back()->with('success', 'Student enrollment approved.');
    }

    public function rejectStudent(Subject $subject, Student $student)
    {
        $subject->students()->detach($student->id);

        return redirect()->back()->with('success', 'Student enrollment rejected.');
    }
}
