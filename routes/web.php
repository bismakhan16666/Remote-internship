<?php
use App\Http\Controllers\StudentController; //Lec13 Create Controller
use App\Http\Controllers\TestController;
use App\Http\Controllers\ThirdTestController;
use App\Models\Teachers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeachersController;// Lec 22
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Lec:5 Router Explained

Route::get('/', function () {
    return'Welcome To The Laravel Student Management';
});
/*
//Lec:6 Route Grouping and naming 

Route::prefix('details')->group(function(){
  Route::get('students', function () {
    return'This Page Is For Students Detail';
  })->name('Students-Detail');
  Route::get('teachers', function () {
    return'This Page Is For Teachers Detail';
  })->name('Teachers-Detail');  
});

//Lec:7 Route Parameters & Fallback

Route::get('student/{id}/{reg}', function ($id,$reg) {
    return'Student Id is ' . $id . 'Student Registeration is ' . $reg;
});
Route::fallback(function () {
    return'The Page Is Not found Please Try Again';
});

//Lec:8 View Explined

Route::get('about-us', function () {
    $name="Tester";  //Lec:9 Passing Data fron route to view
    $email="tester@gmail.com";
    return view('aboutus')->with('name' , $name)->with('email' , $email);
});
Route::view('contact-us', 'contactus' , ['name' => 'Tester' , 'email' => 'tester@gmail.com']);

//Lec:10 Blade directives

Route::post('contact-us', function () {
    return back()->with('success', 'Your message has been sent successfully!');
});

//Lec13 Create Controller

Route::controller(StudentController::class)->group (function(){
Route::get('students','index');
Route::get('about-us/{id}/{name}','aboutUs'); //Lec 14  Passing Route Data to Controllers
});

//Lec16 Create Controller
Route::get('invoke', TestController::class);
Route::resource('Third-Test', ThirdTestController::class);
*/
//Lec 22
/*
Route::get('teachers', function (){
    return Teachers::all();
}) ;
 */
//Lec 22
Route::get('teachers', [TeachersController::class, 'index']); 
//Lec 23
Route::get('add-teachers', [TeachersController::class, 'add']); 
Route::get('show-teachers/{id}', [TeachersController::class, 'show']); 
Route::get('update-teachers/{id}', [TeachersController::class, 'update']); 
Route::get('delete-teachers/{id}', [TeachersController::class, 'delete']); 