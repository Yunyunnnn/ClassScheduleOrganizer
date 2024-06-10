<?php

namespace App\Http\Controllers\StudentAuth;

use App\Http\Controllers\Controller;
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
        $credentials = $request->only('student_id', 'password');

        \Log::info('Attempting login with credentials: ', $credentials);

        if (Auth::guard('student')->attempt($credentials)) {
            \Log::info('Login successful, redirecting to home');
            return redirect()->intended(route('student.home'));
        }

        \Log::warning('Login failed, redirecting back with error');
        return redirect()->back()->withErrors(['message' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('student')->logout();

        return redirect('/student/login');
    }
}

