<?php

namespace App\Http\Controllers\StudentAuth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('studentAuth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = Student::where('email', $request->email)->first();
        if ($user && !$user->approved) {
            return redirect()->back()->withErrors(['message' => 'Your account is not approved yet.']);
        }

        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->intended('student/home');
        }

        return redirect()->back()->withErrors(['message' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('student')->logout();

        return redirect('/student/login');
    }
}
