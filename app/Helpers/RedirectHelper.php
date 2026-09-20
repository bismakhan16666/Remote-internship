<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RedirectHelper
{
    /**
     * User ko uske role ke hisaab se redirect karo.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function redirectByRole()
    {
        // Agar user logged in nahi hai
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        return match ($user->user_type) {
            'admin'   => redirect('/students'),
            'teacher' => redirect('/teacher/dashboard'),
            'student' => redirect('/student/dashboard'),
            default   => redirect('/login'),
        };
    }
}