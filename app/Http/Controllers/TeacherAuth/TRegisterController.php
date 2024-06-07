<?php

namespace App\Http\Controllers\TeacherAuth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('teachersAuth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_initial' => 'required|string|max:1',
            'email' => 'required|string|email|max:255|unique:teachers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $teacher = $this->create($request->all());

        Auth::guard('teacher')->login($teacher);

        return redirect()->route('teacher.home');
    }

    protected function create(array $data)
    {
        return Teacher::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'middle_initial' => $data['middle_initial'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}


    

