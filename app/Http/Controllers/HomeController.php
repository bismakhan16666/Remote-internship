<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->user_type === 'admin' || $user->user_type === 'teacher') {
            return redirect('/students');
        } elseif ($user->user_type === 'student') {
            return redirect('/student/dashboard');
        }

        return 'Welcome to Student Management System!';
    }
}