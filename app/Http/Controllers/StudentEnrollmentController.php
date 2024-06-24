<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StudentEnrollmentController extends Controller
{
    public function enroll(Request $request)
    {
        $request->validate([
            'subject_code' => 'required|exists:subjects,subject_code',
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $subjectCode = $request->input('subject_code');
        $scheduleId = $request->input('schedule_id');

        // Find subject and schedule
        $subject = Subject::where('subject_code', $subjectCode)->firstOrFail();
        $schedule = Schedule::findOrFail($scheduleId);

        // Get current authenticated student
        $student = auth()->user();

        // Check if student is already enrolled in this schedule
        if ($student->isEnrolledInSchedule($scheduleId)) {
            return redirect()->back()->with('warning', 'You are already enrolled in this schedule.');
        }

        DB::beginTransaction();

        try {
            // Attach the student to the subject with the schedule and approved status
            $student->subjects()->attach($subject->subject_code, ['schedule_id' => $scheduleId, 'approved' => false]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Log or handle the exception
            return redirect()->back()->with('error', 'Failed to enroll. Please try again.');
        }

        return redirect()->back()->with('success', 'Enrollment request submitted. Waiting for approval.');
    }
    public function manageStudents(Request $request)
    {
        $teacherId = auth()->id();
        $subjects = Subject::where('teacher_id', $teacherId)
                           ->with('schedules', 'students') // Eager load schedules and students
                           ->get();

        $selectedSubject = null;
        $enrolledStudents = collect();

        // Check if subject is selected based on route parameter
        if ($request->has('subject')) {
            $subjectCode = $request->input('subject');
            $selectedSubject = Subject::where('subject_code', $subjectCode)->firstOrFail();

            // Load enrolled students based on filters or show all
            if ($request->has('show_all')) {
                $enrolledStudents = $selectedSubject->students()
                    ->select('students.student_id', 'students.first_name', 'students.last_name', 'students.email', 'students.block_number as block', 'students.year_level as year', 'students.course')
                    ->get();
            } else {
                $enrolledStudentsQuery = $selectedSubject->students();

                if ($request->has('block_number')) {
                    $enrolledStudentsQuery->where('block_number', $request->input('block_number'));
                }

                if ($request->has('course')) {
                    $enrolledStudentsQuery->where('course', $request->input('course'));
                }

                if ($request->has('year')) {
                    $enrolledStudentsQuery->where('year_level', $request->input('year'));
                }

                $enrolledStudents = $enrolledStudentsQuery
                    ->select('students.student_id', 'students.first_name', 'students.last_name', 'students.email', 'students.block_number as block', 'students.year_level as year', 'students.course')
                    ->get();
            }
        }

        return view('Teachers.index', compact('subjects', 'selectedSubject', 'enrolledStudents'));
    }

    public function showEnrollments()
    {
        // Get the current authenticated teacher's subjects with students who need approval
        $subjects = Subject::with(['students' => function ($query) {
            $query->wherePivot('approved', false);
        }, 'schedules'])->where('teacher_id', auth()->id())->get();

        return view('teachers.index', compact('subjects'));
    }

    public function approveStudent($subjectCode, $studentId)
    {
        $subject = Subject::where('subject_code', $subjectCode)->firstOrFail();
        $subject->students()->updateExistingPivot($studentId, ['approved' => true]);

        return redirect()->back()->with('success', 'Student enrollment approved.');
    }

    public function rejectStudent($subjectCode, $studentId)
    {
        $subject = Subject::where('subject_code', $subjectCode)->firstOrFail();
        $subject->students()->detach($studentId);

        return redirect()->back()->with('success', 'Student enrollment rejected.');
    }


}
