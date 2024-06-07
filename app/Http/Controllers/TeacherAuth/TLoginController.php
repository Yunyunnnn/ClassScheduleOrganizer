<?php

namespace App\Http\Controllers\TeacherAuth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('teachersAuth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = Teacher::where('email', $request->email)->first();
        if ($user && !$user->approved) {
            return redirect()->back()->withErrors(['message' => 'Your account is not approved yet.']);
        }

        if (Auth::guard('teacher')->attempt($credentials)) {
            return redirect()->intended('teacher/home');
        }

        return redirect()->back()->withErrors(['message' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('teacher')->logout();

        return redirect('/teacher/login');
    }
}
