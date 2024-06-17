<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function markAttendance(Request $request, Subject $subject)
    {
        $request->validate([
            'date' => 'required|date',
            'students' => 'required|array',
        ]);

        foreach ($request->students as $studentId => $isPresent) {
            Attendance::updateOrCreate(
                ['subject_id' => $subject->id, 'student_id' => $studentId, 'date' => $request->date],
                ['is_present' => $isPresent]
            );
        }

        return redirect()->back()->with('success', 'Attendance marked successfully.');
    }
}
