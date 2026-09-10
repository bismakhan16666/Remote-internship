<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // ============================================
    // ✅ ADMIN DASHBOARD - All Students (with pagination)
    // ============================================
    public function adminIndex()
    {
        $students = Student::paginate(10);
        
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $inactiveStudents = Student::where('status', 'inactive')->count();
        $pendingStudents = Student::where('status', 'pending')->count();

        return view('students.index', compact(
            'students', 
            'totalStudents', 
            'activeStudents', 
            'inactiveStudents', 
            'pendingStudents'
        ));
    }

    // ============================================
    // ✅ STUDENT DASHBOARD - Sirf apna data
    // ============================================
    public function studentDashboard()
    {
        $user = Auth::user();
        
        // Student record find karein (by user_id ya by email)
        $student = Student::where('user_id', $user->id)
                          ->orWhere('email', $user->email)
                          ->with([
                              'classes.subjects',   // Enrolled Courses
                              'classes.teacher',    // Class Teacher
                              'subjects',           // Subjects + Grades
                              'grades.subject',     // Grades
                              'comments'            // Teacher Remarks
                          ])
                          ->first();

        if (!$student) {
            return redirect('/home')->with('error', 'No student record found. Contact admin.');
        }

        return view('students.dashboard', compact('student'));
    }

    // ============================================
    // CREATE - Show Add Form
    // ============================================
    public function showAddForm()
    {
        return view('students.add');
    }

    // ============================================
    // CREATE - Store Student
    // ============================================
    public function storeStudent(StudentRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('students', 'public');
        }

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'score' => $request->score ?? 0,
            'status' => $request->status,
            'user_id' => 1,
            'image' => $imagePath
        ]);

        return redirect()->route('students.index')->with('success', 'Student Added Successfully!');
    }

    // ============================================
    // UPDATE - Show Edit Form
    // ============================================
    public function showEditForm($id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found!');
        }
        
        return view('students.edit', compact('student'));
    }

    // ============================================
    // UPDATE - Update Student
    // ============================================
    public function updateStudent(StudentRequest $request, $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found!');
        }

        $imagePath = $student->image;
        if ($request->hasFile('image')) {
            if ($student->image && Storage::disk('public')->exists($student->image)) {
                Storage::disk('public')->delete($student->image);
            }
            $imagePath = $request->file('image')->store('students', 'public');
        }

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'score' => $request->score ?? 0,
            'status' => $request->status,
            'image' => $imagePath
        ]);

        return redirect()->route('students.index')->with('success', 'Student Updated Successfully!');
    }

    // ============================================
    // DELETE - Delete Student
    // ============================================
    public function deleteStudent($id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found!');
        }

        if ($student->image && Storage::disk('public')->exists($student->image)) {
            Storage::disk('public')->delete($student->image);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student Deleted Successfully!');
    }

    // ============================================
    // SEARCH - Filters
    // ============================================
    public function search(Request $request)
    {
        $query = Student::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('min_score')) {
            $query->where('score', '>=', $request->min_score);
        }
        if ($request->filled('max_score')) {
            $query->where('score', '<=', $request->max_score);
        }
        if ($request->filled('min_age')) {
            $query->where('age', '>=', $request->min_age);
        }
        if ($request->filled('max_age')) {
            $query->where('age', '<=', $request->max_age);
        }

        $students = $query->paginate(10);
        $students->appends($request->all());

        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $inactiveStudents = Student::where('status', 'inactive')->count();
        $pendingStudents = Student::where('status', 'pending')->count();

        return view('students.index', compact(
            'students', 
            'totalStudents', 
            'activeStudents', 
            'inactiveStudents', 
            'pendingStudents'
        ));
    }
}