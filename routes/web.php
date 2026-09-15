<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//  Auth Routes
Auth::routes();

//  Logout Confirmation
Route::get('/logout-confirm', function () {
    return view('auth.logout');
})->middleware('auth')->name('logout.confirm');

//  Root URL
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->user_type === 'admin') return redirect('/students');
        elseif ($user->user_type === 'teacher') return redirect('/teacher/dashboard');
        elseif ($user->user_type === 'student') return redirect('/student/dashboard');
    }
    return redirect('/login');
});

//  Home
Route::get('/home', function () {
    if (!Auth::check()) return redirect('/login');
    $user = Auth::user();
    if ($user->user_type === 'admin') return redirect('/students');
    elseif ($user->user_type === 'teacher') return redirect('/teacher/dashboard');
    elseif ($user->user_type === 'student') return redirect('/student/dashboard');
    return 'Welcome!';
})->name('home');

//  Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // ============================================
    // ADMIN DASHBOARD
    // ============================================
    Route::get('/students', 'StudentController@adminIndex')->name('students.index');
    Route::get('/admin/dashboard', 'StudentController@adminIndex')->name('admin.dashboard');

    // ============================================
    // STUDENT CRUD
    // ============================================
    Route::get('add-student', 'StudentController@showAddForm')->name('students.create');
    Route::post('add-student', 'StudentController@storeStudent')->name('students.store');
    Route::get('edit-student/{id}', 'StudentController@showEditForm')->name('students.edit');
    Route::put('edit-student/{id}', 'StudentController@updateStudent')->name('students.update');
    Route::delete('delete-student/{id}', 'StudentController@deleteStudent')->name('students.delete');
    Route::get('search', 'StudentController@search')->name('students.search');

    // ============================================
    // TEACHER CRUD
    // ============================================
    Route::get('add-teacher', 'TeachersController@create')->name('teachers.create');
    Route::post('add-teacher', 'TeachersController@store')->name('teachers.store');
    Route::get('edit-teacher/{id}', 'TeachersController@edit')->name('teachers.edit');
    Route::put('edit-teacher/{id}', 'TeachersController@update')->name('teachers.update');
    Route::delete('delete-teacher/{id}', 'TeachersController@destroy')->name('teachers.delete');

    // ============================================
    // TEACHER DASHBOARD + ROUTES
    // ============================================
    Route::get('/teacher/dashboard', 'TeachersController@dashboard')->name('teacher.dashboard');
    Route::get('/teacher/students', 'TeachersController@myStudents')->name('teacher.students');
    Route::get('/teacher/class/{id}', 'TeachersController@showClass')->name('teacher.class');
    Route::get('/teacher/student/{id}', 'TeachersController@showStudent')->name('teacher.student');
    Route::post('/teacher/student/{id}/comment', 'TeachersController@addComment')->name('teacher.comment');

    // ============================================
    // STUDENT DASHBOARD
    // ============================================
    Route::get('/student/dashboard', 'StudentController@studentDashboard')->name('student.dashboard');

    // ============================================
    // STATS
    // ============================================
    Route::get('stats/dashboard', 'StatsController@dashboard')->name('stats.dashboard');
});

// Fallback
Route::fallback(function () {
    return 'The Page Is Not Found. Please Try Again';
});