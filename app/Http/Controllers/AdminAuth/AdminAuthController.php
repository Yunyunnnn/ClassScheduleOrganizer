<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/home');
        }

        return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function approve($id, $type)
{
    if ($type == 'Student') {
        $user = \App\Models\Student::find($id);
    } elseif ($type == 'Teacher') {
        $user = \App\Models\Teacher::find($id);
    } else {
        return redirect()->back()->with('error', 'Invalid user type.');
    }

    if ($user) {
        $user->approved = true;
        $user->save();
        return redirect()->route('admin.home')->with('success', "$type approved successfully.");
    }

    return redirect()->back()->with('error', 'User not found.');
}
}

