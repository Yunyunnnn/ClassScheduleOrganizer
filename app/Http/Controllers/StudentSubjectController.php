<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Student;


class StudentSubjectController extends Controller
{
    public function enroll(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $subject = Subject::findOrFail($request->subject_id);

        auth()->user()->subjects()->syncWithoutDetaching([$subject->id]);

        return redirect()->back()->with('success', 'Enrolled successfully in ' . $subject->name);
    }
}
