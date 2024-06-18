<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

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

        $teacherId = auth()->id();
        $existingSubject = Subject::where('teacher_id', $teacherId)
                                  ->where('subject_code', $request->code)
                                  ->exists();

        if ($existingSubject) {
            return redirect()->back()->with('warning', 'Subject code already exists for your account.');
        }

        $subject = Subject::create([
            'name' => $request->name,
            'subject_code' => $request->code,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'days_of_week' => implode(',', $request->days_of_week),
            'teacher_id' => $teacherId,
        ]);

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
    
}
