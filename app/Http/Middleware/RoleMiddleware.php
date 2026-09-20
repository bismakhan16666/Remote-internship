<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check 1: User logged in hai?
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check 2: User ka role allowed hai?
        if (!in_array(Auth::user()->user_type, $roles)) {
            abort(403, 'You are not allowed to access this page.');
        }

        return $next($request);
    }
}