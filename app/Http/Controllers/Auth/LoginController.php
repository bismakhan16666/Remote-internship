<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * ✅ Login ke baad role-based redirect
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->user_type === 'admin') {
            return '/students';
        } elseif ($user->user_type === 'teacher') {
            return '/teacher/dashboard';
        } elseif ($user->user_type === 'student') {
            return '/student/dashboard';
        }

        return '/home';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}