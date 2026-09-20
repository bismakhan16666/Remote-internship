<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\StatsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Breeze Auth Routes
require __DIR__.'/auth.php';

// Root URL — role ke hisaab se redirect
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->user_type === 'admin') return redirect('/students');
        elseif ($user->user_type === 'teacher') return redirect('/teacher/dashboard');
        elseif ($user->user_type === 'student') return redirect('/student/dashboard');
    }
    return redirect('/login');
});

// Dashboard (simple — koi redirect nahi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// ================== ADMIN ONLY ==================
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/students', [StudentController::class, 'adminIndex'])->name('students.index');
    Route::get('/admin/dashboard', [StudentController::class, 'adminIndex'])->name('admin.dashboard');

    // Student CRUD
    Route::get('add-student', [StudentController::class, 'showAddForm'])->name('students.create');
    Route::post('add-student', [StudentController::class, 'storeStudent'])->name('students.store');
    Route::get('edit-student/{id}', [StudentController::class, 'showEditForm'])->name('students.edit');
    Route::put('edit-student/{id}', [StudentController::class, 'updateStudent'])->name('students.update');
    Route::delete('delete-student/{id}', [StudentController::class, 'deleteStudent'])->name('students.delete');
    Route::get('search', [StudentController::class, 'search'])->name('students.search');

    // Teacher CRUD
    Route::get('add-teacher', [TeachersController::class, 'create'])->name('teachers.create');
    Route::post('add-teacher', [TeachersController::class, 'store'])->name('teachers.store');
    Route::get('edit-teacher/{id}', [TeachersController::class, 'edit'])->name('teachers.edit');
    Route::put('edit-teacher/{id}', [TeachersController::class, 'update'])->name('teachers.update');
    Route::delete('delete-teacher/{id}', [TeachersController::class, 'destroy'])->name('teachers.delete');

    // Stats
    Route::get('stats/dashboard', [StatsController::class, 'dashboard'])->name('stats.dashboard');
});


// ================== TEACHER ONLY ==================
Route::middleware(['auth', 'role:teacher'])->group(function () {

    Route::get('/teacher/dashboard', [TeachersController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/teacher/students', [TeachersController::class, 'myStudents'])->name('teacher.students');
    Route::get('/teacher/class/{id}', [TeachersController::class, 'showClass'])->name('teacher.class');
    Route::get('/teacher/student/{id}', [TeachersController::class, 'showStudent'])->name('teacher.student');
    Route::post('/teacher/student/{id}/comment', [TeachersController::class, 'addComment'])->name('teacher.comment');
});


// ================== STUDENT ONLY ==================
Route::middleware(['auth', 'role:student'])->group(function () {

    Route::get('/student/dashboard', [StudentController::class, 'studentDashboard'])->name('student.dashboard');
});


Route::fallback(function () {
    return 'The Page Is Not Found. Please Try Again';
});