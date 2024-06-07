<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TeacherAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('teacher')->check()) {
            return $next($request);
        }

        return redirect()->route('teacher.login');
    }
}
