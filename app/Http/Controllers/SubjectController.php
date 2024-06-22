<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Teacher;


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
            'code' => 'required|string|max:255',
            'time_from' => 'required',
            'time_to' => 'required',
            'days_of_week' => 'required|array',
        ]);

        // Check if subject code already exists
        $existingSubject = Subject::where('subject_code', $request->code)->exists();

        if ($existingSubject) {
            return redirect()->back()->with('warning', 'Subject code already exists.');
        }

        // Create a new subject and associate it with the authenticated teacher
        $subject = new Subject();
        $subject->name = $request->name;
        $subject->subject_code = $request->code;
        $subject->time_from = $request->time_from;
        $subject->time_to = $request->time_to;
        $subject->days_of_week = implode(',', $request->days_of_week);
        $subject->teacher_id = auth()->id();
        $subject->save();

        return redirect()->route('teacher.subjects.index')->with('success', 'Subject added successfully.');
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
        ]);

        $subject->update([
            'name' => $request->name,
            'subject_code' => $request->code,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'days_of_week' => implode(',', $request->days_of_week),
        ]);

        return redirect()->route('teacher.subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('teacher.subjects.index')->with('success', 'Subject deleted successfully.');
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


}
