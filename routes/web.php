<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ Auth Routes
Auth::routes();

// ✅ Root URL - Role-based redirect
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->user_type === 'admin') {
            return redirect('/students');
        } elseif ($user->user_type === 'teacher') {
            return redirect('/teacher/dashboard');
        } elseif ($user->user_type === 'student') {
            return redirect('/student/dashboard');
        }
    }
    return redirect('/login');
});

// ✅ Home (fallback)
Route::get('/home', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    
    $user = Auth::user();
    if ($user->user_type === 'admin') {
        return redirect('/students');
    } elseif ($user->user_type === 'teacher') {
        return redirect('/teacher/dashboard');
    } elseif ($user->user_type === 'student') {
        return redirect('/student/dashboard');
    }
    
    return 'Welcome!';
})->name('home');

// ✅ Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // ============================================
    // ADMIN DASHBOARD
    // ============================================
    Route::get('/students', 'StudentController@adminIndex')->name('students.index');
    Route::get('/admin/dashboard', 'StudentController@adminIndex')->name('admin.dashboard');

    // ============================================
    // TEACHER DASHBOARD ✅ NAYA
    // ============================================
    Route::get('/teacher/dashboard', 'TeacherController@dashboard')->name('teacher.dashboard');
    Route::get('/teacher/class/{id}', 'TeacherController@showClass')->name('teacher.class');
    Route::get('/teacher/student/{id}', 'TeacherController@showStudent')->name('teacher.student');
    Route::post('/teacher/student/{id}/comment', 'TeacherController@addComment')->name('teacher.comment');

    // ============================================
    // STUDENT DASHBOARD
    // ============================================
    Route::get('/student/dashboard', 'StudentController@studentDashboard')->name('student.dashboard');

    // ============================================
    // STUDENT CRUD (Admin)
    // ============================================
    Route::get('add-student', 'StudentController@showAddForm')->name('students.create');
    Route::post('add-student', 'StudentController@storeStudent')->name('students.store');
    Route::get('edit-student/{id}', 'StudentController@showEditForm')->name('students.edit');
    Route::put('edit-student/{id}', 'StudentController@updateStudent')->name('students.update');
    Route::delete('delete-student/{id}', 'StudentController@deleteStudent')->name('students.delete');
    Route::get('search', 'StudentController@search')->name('students.search');

    // ============================================
    // STATS
    // ============================================
    Route::get('stats/dashboard', 'StatsController@dashboard')->name('stats.dashboard');
    Route::get('stats/basic', 'StatsController@basicAggregates')->name('stats.basic');
    Route::get('stats/relationships', 'StatsController@relationshipCounts')->name('stats.relationships');
    Route::get('stats/advanced', 'StatsController@advancedAggregates')->name('stats.advanced');

    // ============================================
    // RELATIONSHIPS
    // ============================================
    Route::get('/has-one-through', 'RelationshipController@hasOneThrough');
    Route::get('/has-many-through', 'RelationshipController@hasManyThrough');
    Route::get('/users-with-class-count', 'RelationshipController@allUsersWithClassCount');

    // ============================================
    // COMMENTS (Student)
    // ============================================
    Route::post('student/{id}/comment', 'CommentController@addStudentComment')->name('students.comment');
    Route::get('comment/{id}', 'CommentController@show');
});

// Public Routes
Route::get('about-us', function () {
    return view('aboutus');
});

Route::view('contact-us', 'contactus');

Route::fallback(function () {
    return 'The Page Is Not Found. Please Try Again';
});