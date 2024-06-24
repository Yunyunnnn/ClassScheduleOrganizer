<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Schedule;


class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('teacher_id', auth()->id())->get();
        return view('Subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('Subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:255|unique:subjects,subject_code',
            'schedules' => 'required|array|min:1', // Ensure at least one schedule is provided
            'schedules.*.block_number' => 'required|string|max:255',
            'schedules.*.year_level' => 'required|integer|between:1,4', // Adjust range based on your needs
            'schedules.*.course' => 'required|string|max:255',
            'schedules.*.time_from' => 'required|date_format:H:i',
            'schedules.*.time_to' => 'required|date_format:H:i|after:schedules.*.time_from',
            'schedules.*.days_of_week' => 'required|array',
            'schedules.*.room' => 'required|string|max:255',
        ]);

        try {
            // Start database transaction
            DB::beginTransaction();

            // Create the subject
            $subject = Subject::create([
                'name' => $request->name,
                'subject_code' => $request->subject_code,
                'teacher_id' => auth()->id(),
            ]);

            // Create schedules for the subject
            foreach ($request->schedules as $scheduleData) {
                $schedule = new Schedule([
                    'block_number' => $scheduleData['block_number'],
                    'year_level' => $scheduleData['year_level'],
                    'course' => $scheduleData['course'],
                    'time_from' => $scheduleData['time_from'],
                    'time_to' => $scheduleData['time_to'],
                    'days_of_week' => implode(',', $scheduleData['days_of_week']),
                    'room' => $scheduleData['room'],
                ]);

                $subject->schedules()->save($schedule);
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('teacher.subjects.list')->with('success', 'Subject created successfully.');
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create subject. ' . $e->getMessage());
        }
    }

    public function edit(Subject $subject)
    {
        return view('Subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:255',
            'schedules.*.block_number' => 'required|string|max:255',
            'schedules.*.year_level' => 'required|integer',
            'schedules.*.course' => 'required|string|max:255',
            'schedules.*.time_from' => 'required',
            'schedules.*.time_to' => 'required',
            'schedules.*.days_of_week' => 'required|array',
            'schedules.*.room' => 'required|string|max:255',
        ]);

        $subject->update([
            'name' => $request->name,
            'subject_code' => $request->subject_code,
        ]);

        foreach ($request->schedules as $scheduleData) {
            if (isset($scheduleData['id'])) {
                $schedule = Schedule::find($scheduleData['id']);
                $schedule->update([
                    'block_number' => $scheduleData['block_number'],
                    'year_level' => $scheduleData['year_level'],
                    'course' => $scheduleData['course'],
                    'time_from' => $scheduleData['time_from'],
                    'time_to' => $scheduleData['time_to'],
                    'days_of_week' => implode(',', $scheduleData['days_of_week']),
                    'room' => $scheduleData['room'],
                ]);
            } else {
                $subject->schedules()->create([
                    'block_number' => $scheduleData['block_number'],
                    'year_level' => $scheduleData['year_level'],
                    'course' => $scheduleData['course'],
                    'time_from' => $scheduleData['time_from'],
                    'time_to' => $scheduleData['time_to'],
                    'days_of_week' => implode(',', $scheduleData['days_of_week']),
                    'room' => $scheduleData['room'],
                ]);
            }
        }

        return redirect()->route('teacher.subjects.list')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        // Detach related students from this subject's schedules
        foreach ($subject->schedules as $schedule) {
            $schedule->students()->detach();
        }

        // Now delete the subject
        $subject->delete();

        return redirect()->route('teacher.subjects.list')->with('success', 'Subject deleted successfully.');
    }


    public function students(Subject $subject)
    {
        $students = $subject->students()->get();
        return view('subjects.students', compact('students', 'subject'));
    }

    public function searchResults(Request $request)
    {
        $subjectCode = $request->input('subjectId');
        $subjects = Subject::where('subject_code', 'LIKE', '%' . $subjectCode . '%')->get();

        return view('Students.subject-search', compact('subjects', 'subjectCode'));
    }

    public function showSearchForm(Request $request)
    {
        return view('Students.subject-search');
    }

    public function viewhome(Request $request)
    {
        return view('Students.dashboard');
    }

    public function viewStudents(Request $request, $subject = null)
    {
        $teacherId = auth()->id();
        $subjects = Subject::where('teacher_id', $teacherId)->get();

        $selectedSubject = null;
        $enrolledStudents = collect();
        $blocks = Student::select('block_number')->distinct()->pluck('block_number');
        $courses = Student::select('course')->distinct()->pluck('course');
        $years = Student::select('year_level')->distinct()->pluck('year_level');

        if ($subject) {
            $selectedSubject = Subject::where('teacher_id', $teacherId)
                ->where('subject_code', $subject)
                ->firstOrFail();

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

        return view('Teachers.ViewStudents', compact('subjects', 'selectedSubject', 'enrolledStudents', 'blocks', 'courses', 'years'));
    }

    public function storeAnnouncement(Request $request, Subject $subject)
    {
        $request->validate([
            'announcement' => 'required|string',
        ]);

        return back()->with('success', 'Announcement created successfully.');
    }

    public function manageStudents()
    {
        $teacherId = auth()->id();
        $subjects = Subject::where('teacher_id', $teacherId)
                           ->with('schedules', 'students') // Eager load schedules and students
                           ->get();

        return view('Teachers.ViewStudents', compact('subjects'));
    }


}
