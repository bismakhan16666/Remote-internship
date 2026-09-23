<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

// ============================================
// ROOT URL
// ============================================
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->user_type === 'admin') return redirect('/students');
        elseif ($user->user_type === 'teacher') return redirect('/teacher/dashboard');
        elseif ($user->user_type === 'student') return redirect('/student/dashboard');
    }
    return redirect('/login');
});

// ============================================
// DASHBOARD
// ============================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// ============================================
// ADMIN ONLY ROUTES
// ============================================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Admin Dashboard
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


    // ============================================
    // SESSION DEMO ROUTES
    // ============================================
    Route::get('/session/set', function () {
        session([
            'user_name' => Auth::user()->name,
            'user_role' => Auth::user()->user_type,
            'login_time' => now()->toDateTimeString(),
        ]);
        return redirect('/session/show')->with('success', 'Session data stored!');
    })->name('session.set');

    Route::get('/session/show', function () {
        $userName = session('user_name');
        $userRole = session('user_role');
        $loginTime = session('login_time');
        return view('session.show', compact('userName', 'userRole', 'loginTime'));
    })->name('session.show');

    Route::get('/session/clear', function () {
        session()->forget(['user_name', 'user_role', 'login_time']);
        return redirect('/session/show')->with('success', 'Session data cleared!');
    })->name('session.clear');


    // ============================================
    // CACHE DEMO ROUTES
    // ============================================
    Route::get('/cache/store', function () {
        Cache::put('demo_data', [
            'message' => 'Hello from Cache!',
            'time' => now()->toDateTimeString(),
        ], 600);
        return redirect('/cache/show')->with('success', 'Cache stored for 10 minutes!');
    })->name('cache.store');

    Route::get('/cache/show', function () {
        $data = Cache::get('demo_data');
        $hasCache = Cache::has('demo_data');
        return view('cache.show', compact('data', 'hasCache'));
    })->name('cache.show');

    Route::get('/cache/clear', function () {
        Cache::forget('demo_data');
        return redirect('/cache/show')->with('success', 'Cache cleared!');
    })->name('cache.clear');

    Route::get('/cache/remember', function () {
        $students = Cache::remember('remember_students', 600, function () {
            return \App\Models\Student::take(5)->get();
        });
        return view('cache.remember', compact('students'));
    })->name('cache.remember');

    Route::get('/cache/clear-all', function () {
        Cache::flush();
        return redirect()->back()->with('success', 'All cache cleared!');
    })->name('cache.clear-all');


    // ============================================
    // EMAIL TEST ROUTES
    // ============================================
    Route::get('/email/test', function () {
        Mail::raw('This is a test email from Student Management System!', function ($message) {
            $message->to(Auth::user()->email)
                    ->subject('Test Email from SMS');
        });
        return redirect('/system-dashboard')->with('success', 'Test email sent! Check log file.');
    })->name('email.test');

    Route::get('/email/test-attachment', function () {
        $student = \App\Models\Student::first();

        if (!$student) {
            return redirect('/system-dashboard')->with('error', 'No student found to test attachment.');
        }

        Mail::to(Auth::user()->email)->send(new \App\Mail\StudentAddedMail($student));
        return redirect('/system-dashboard')->with('success', 'Email with attachment sent! Check log file.');
    })->name('email.test.attachment');


    // ============================================
    // QUEUE DEMO ROUTES
    // ============================================
    Route::get('/queue/test', function () {
        \App\Jobs\SendWelcomeEmail::dispatch(Auth::user());
        return redirect('/system-dashboard')->with('success', 'Job dispatched to queue!');
    })->name('queue.test');

    Route::get('/queue/status', function () {
        $pending = DB::table('jobs')->count();
        $failed  = DB::table('failed_jobs')->count();
        
        return response()->json([
            'pending_jobs' => $pending,
            'failed_jobs'  => $failed,
            'driver'       => config('queue.default'),
        ]);
    })->name('queue.status');


    // ============================================
    // EVENT DEMO ROUTES
    // ============================================
    Route::get('/event/test', function () {
        $student = \App\Models\Student::first();
        
        if (!$student) {
            return redirect('/system-dashboard')->with('error', 'No student found to test event.');
        }

        event(new \App\Events\StudentAdded($student));
        
        return redirect('/system-dashboard')->with('success', 'StudentAdded event fired! Check log.');
    })->name('event.test');


    // ============================================
    // WEBSOCKET DEMO ROUTES
    // ============================================
    Route::get('/websocket/test', function () {
        $student = \App\Models\Student::first();

        if (!$student) {
            return redirect('/system-dashboard')->with('error', 'No student found to test websocket.');
        }

        broadcast(new \App\Events\StudentAdded($student));

        return redirect('/system-dashboard')->with('success', 'StudentAdded event broadcasted! Check real-time notification.');
    })->name('websocket.test');


    // ============================================
    // SYSTEM DASHBOARD
    // ============================================
    Route::get('/system-dashboard', function () {
        // 1. Stats
        $stats = [
            'totalStudents'    => \App\Models\Student::count(),
            'totalTeachers'    => \App\Models\Teachers::count(),
            'totalClasses'     => \App\Models\Classes::count(),
            'totalSubjects'    => \App\Models\Subject::count(),
            'verifiedUsers'    => \App\Models\User::whereNotNull('email_verified_at')->count(),
            'unverifiedUsers'  => \App\Models\User::whereNull('email_verified_at')->count(),
        ];

        // 2. Email Log
        $logPath = storage_path('logs/laravel.log');
        $emailLogs = [];
        if (file_exists($logPath)) {
            $lines = file($logPath);
            $emailLines = array_filter($lines, function ($line) {
                return str_contains($line, 'Subject:') || str_contains($line, 'To:');
            });
            $emailLogs = array_slice(array_reverse($emailLines), 0, 5);
        }

        // 3. Queue Status
        $queueJobs = ['pending' => 0, 'failed' => 0];
        if (Schema::hasTable('jobs')) {
            $queueJobs['pending'] = DB::table('jobs')->count();
        }
        if (Schema::hasTable('failed_jobs')) {
            $queueJobs['failed'] = DB::table('failed_jobs')->count();
        }

        // 4. Event Log
        $eventLogs = [];
        if (file_exists($logPath)) {
            $lines = file($logPath);
            $eventLines = array_filter($lines, function ($line) {
                return str_contains($line, 'Event Fired') || str_contains($line, 'StudentAdded');
            });
            $eventLogs = array_slice(array_reverse($eventLines), 0, 5);
        }

        // 5. Cache Info
        $cacheInfo = [
            'driver'    => config('cache.default'),
            'has_demo'  => Cache::has('demo_data'),
            'has_stats' => Cache::has('dashboard_stats'),
        ];

        // 6. Session Info
        $sessionInfo = [
            'user_name'      => session('user_name'),
            'user_role'      => session('user_role'),
            'login_time'     => session('login_time'),
            'student_viewed' => session('student_viewed'),
        ];

        return view('system-dashboard', compact(
            'stats', 'emailLogs', 'queueJobs', 'eventLogs', 'cacheInfo', 'sessionInfo'
        ));
    })->name('system.dashboard');
});


// ============================================
// TEACHER ONLY ROUTES
// ============================================
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeachersController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/teacher/students', [TeachersController::class, 'myStudents'])->name('teacher.students');
    Route::get('/teacher/class/{id}', [TeachersController::class, 'showClass'])->name('teacher.class');
    Route::get('/teacher/student/{id}', [TeachersController::class, 'showStudent'])->name('teacher.student');
    Route::post('/teacher/student/{id}/comment', [TeachersController::class, 'addComment'])->name('teacher.comment');
});


// ============================================
// STUDENT ONLY ROUTES
// ============================================
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'studentDashboard'])->name('student.dashboard');
});


Route::fallback(function () {
    return 'The Page Is Not Found. Please Try Again';
});