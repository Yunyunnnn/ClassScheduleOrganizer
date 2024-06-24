<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('teacher_id', auth()->id())->get();
        return view('Subjects.index', compact('subjects'));
    }

    public function create()
    {
        $subjects = Subject::where('teacher_id', auth()->id())->get();
        return view('Subjects.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'time_from' => 'required',
            'time_to' => 'required',
            'days_of_week' => 'required|array',
            'room' => 'required|string|max:255',
        ]);

        $existingSubject = Subject::where('subject_code', $request->code)->exists();

        if ($existingSubject) {
            return redirect()->back()->with('warning', 'Subject code already exists.');
        }

        $subject = new Subject();
        $subject->name = $request->name;
        $subject->subject_code = $request->code;
        $subject->time_from = $request->time_from;
        $subject->time_to = $request->time_to;
        $subject->days_of_week = implode(',', $request->days_of_week);
        $subject->teacher_id = auth()->id();
        $subject->room = $request->room;
        $subject->save();

        return redirect()->route('teacher.subjects.list')->with('success', 'Subject added successfully.');
    }

    public function edit(Subject $subject)
    {
        return view('Subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'time_from' => 'required',
            'time_to' => 'required',
            'days_of_week' => 'required|array',
            'room' => 'required|string|max:255',
        ]);

        $subject->update([
            'name' => $request->name,
            'subject_code' => $request->code,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'days_of_week' => implode(',', $request->days_of_week),
            'room' => $request->room,
        ]);

        return redirect()->route('teacher.subjects.list')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
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
        $subjects = Subject::where('teacher_id', auth()->id())->get();

        $selectedSubject = null;
        $enrolledStudents = collect();
        $blocks = Student::select('block_number')->distinct()->pluck('block_number');
        $courses = Student::select('course')->distinct()->pluck('course');
        $years = Student::select('year_level')->distinct()->pluck('year_level');

        if ($subject) {
            $selectedSubject = Subject::findOrFail($subject);

            if ($request->has('show_all')) {
                $enrolledStudents = $selectedSubject->students()
                    ->select('students.student_id', 'students.first_name', 'students.last_name', 'students.email', 'students.block_number as block', 'students.year_level as year', 'students.course')
                    ->get();
            } else {
                if ($selectedSubject) {
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
        $subjects = Subject::where('teacher_id', auth()->id())->get();
        return view('Teachers.view_students', compact('subjects'));
    }


}
