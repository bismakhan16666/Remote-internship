<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Role-based redirect
        $user = Auth::user();
        if ($user->user_type === 'admin') {
            return redirect('/students');
        } elseif ($user->user_type === 'teacher') {
            return redirect('/teacher/dashboard');
        } elseif ($user->user_type === 'student') {
            return redirect('/student/dashboard');
        }

        return redirect('/dashboard');
    }

    /**
     * Destroy an authenticated session (LOGOUT).
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}