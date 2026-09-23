<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Notifications\CustomVerifyEmail;   // 👈 Custom notification import

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => ['required', 'in:admin,teacher,student'],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);

        // ============================================
        // BEFORE (OLD CODE):
        // ============================================
        // event(new Registered($user));

        // ============================================
        // AFTER (NEW CODE — CUSTOM VERIFICATION EMAIL):
        // ============================================
        // WHAT'S NEW:
        // 1. Default notification ke bajaye custom notification bhejo
        // 2. Custom email template use karo
        // 3. Custom subject aur design
        // ============================================

        // 👇 Custom notification bhejo
        $user->notify(new CustomVerifyEmail());

        // Event bhi fire karo (optional)
        event(new Registered($user));

        Auth::login($user);

        // Role-based redirect
        if ($user->user_type === 'admin') {
            return redirect('/students');
        } elseif ($user->user_type === 'teacher') {
            return redirect('/teacher/dashboard');
        } elseif ($user->user_type === 'student') {
            return redirect('/student/dashboard');
        }

        return redirect('/dashboard');
    }
}