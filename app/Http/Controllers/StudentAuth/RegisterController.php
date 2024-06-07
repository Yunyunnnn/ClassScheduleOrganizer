<?php

namespace App\Http\Controllers\StudentAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('studentAuth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'student_id' => ['required', 'string', 'max:255', 'unique:students'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return Student::create([
            'student_id' => $data['student_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'approved' => false,
        ]);
    }    

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
    
        $student = $this->create($request->all());
    
        auth()->guard('student')->login($student);
    
        return redirect()->route('student.home'); 
    }

    
}
