<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApproved
{
    public function handle(Request $request, Closure $next)
    {
        \Log::info('CheckApproved middleware is called.');

        if (!auth()->check()) {
            \Log::info('User is not authenticated. Redirecting to login.');
            return redirect()->route('student.login');
        }

        if (auth()->check() && !auth()->user()->approved) {
            \Log::info('User is not approved.');
            return redirect()->route('not.approved');
        }

        \Log::info('User is approved.');

        return $next($request);
    }
}
