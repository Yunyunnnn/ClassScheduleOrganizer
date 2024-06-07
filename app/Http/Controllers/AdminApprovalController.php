<?

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;

class AdminApprovalController extends Controller
{
    public function showStudents()
    {
        $students = Student::where('approved', false)->get();
        return view('admin.approve_students', compact('students'));
    }

    public function showTeachers()
    {
        $teachers = Teacher::where('approved', false)->get();
        return view('admin.approve_teachers', compact('teachers'));
    }

    public function approveStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->approved = true;
        $student->save();

        return redirect()->route('admin.approve.students')->with('status', 'Student approved successfully');
    }

    public function approveTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->approved = true;
        $teacher->save();

        return redirect()->route('admin.approve.teachers')->with('status', 'Teacher approved successfully');
    }
}


