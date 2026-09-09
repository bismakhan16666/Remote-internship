<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ThirdTestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('test-view', function () {
    return view('students.add');
});
// Lec:5 Router Explained
Route::get('/', function () {
    return 'Welcome To The Laravel Student Management';
});

// Lec:6 Route Grouping and naming 
Route::prefix('details')->group(function(){
  Route::get('students', function () {
    return'This Page Is For Students Detail';
  })->name('Students-Detail');
  Route::get('teachers', function () {
    return'This Page Is For Teachers Detail';
  })->name('Teachers-Detail');  
});

// Lec:7 Route Parameters & Fallback
Route::get('student/{id}/{reg}', function ($id,$reg) {
    return'Student Id is ' . $id . 'Student Registration is ' . $reg;
});
Route::fallback(function () {
    return'The Page Is Not found Please Try Again';
});

// Lec:8 View Explained
Route::get('about-us', function () {
    $name="Tester";
    $email="tester@gmail.com";
    return view('aboutus')->with('name' , $name)->with('email' , $email);
});
Route::view('contact-us', 'contactus' , ['name' => 'Tester' , 'email' => 'tester@gmail.com']);

// Lec:10 Blade directives
Route::post('contact-us', function () {
    return back()->with('success', 'Your message has been sent successfully!');
});

// Lec:13 Create Controller
Route::controller(StudentController::class)->group(function(){
Route::get('students','index');
Route::get('about-us/{id}/{name}','aboutUs');
});

// Lec:16 Create Controller
Route::get('invoke', TestController::class);
Route::resource('Third-Test', ThirdTestController::class);

// ============================================
//  COMPLETE CRUD ROUTES
// ============================================

// Dashboard - Read all students
Route::get('/', [StudentController::class, 'index'])->name('students.index');

// Show Add Form - Create
Route::get('add-student', [StudentController::class, 'showAddForm'])->name('students.create');

// Store Student - Create
Route::post('add-student', [StudentController::class, 'storeStudent'])->name('students.store');

// Show Edit Form - Update
Route::get('edit-student/{id}', [StudentController::class, 'showEditForm'])->name('students.edit');

// Update Student - Update
Route::put('edit-student/{id}', [StudentController::class, 'updateStudent'])->name('students.update');

// Delete Student - Delete
Route::delete('delete-student/{id}', [StudentController::class, 'deleteStudent'])->name('students.delete');

// Search with filters - Read
Route::get('/search', [StudentController::class, 'search'])->name('students.search');