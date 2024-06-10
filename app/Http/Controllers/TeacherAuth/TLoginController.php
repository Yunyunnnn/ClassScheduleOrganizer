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

        \Log::info('Attempting login with credentials: ', $credentials);

        if (Auth::guard('teacher')->attempt($credentials)) {
            \Log::info('Login successful, redirecting to home');
            return redirect()->intended(route('teacher.home'));
        }

        \Log::warning('Login failed, redirecting back with error');
        return redirect()->back()->withErrors(['message' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('teacher')->logout();

        return redirect('/teacher/login');
    }
}
