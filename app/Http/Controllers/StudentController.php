<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teachers;
use App\Models\Classes;
use App\Models\Subject;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // ============================================
    //  ADMIN DASHBOARD - Students + Teachers + Stats
    // ============================================
    public function adminIndex()
    {
        $students = Student::with(['classes', 'user'])
                           ->paginate(10, ['*'], 'students_page');
        
        $teachers = Teachers::with(['user', 'classes'])
                            ->paginate(10, ['*'], 'teachers_page');

        // Stats
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $inactiveStudents = Student::where('status', 'inactive')->count();
        $pendingStudents = Student::where('status', 'pending')->count();
        $totalTeachers = Teachers::count();
        $totalClasses = Classes::count();
        $totalSubjects = Subject::count();

        return view('students.index', compact(
            'students', 'teachers',
            'totalStudents', 'activeStudents', 'inactiveStudents', 'pendingStudents',
            'totalTeachers', 'totalClasses', 'totalSubjects'
        ));
    }

    // Student Dashboard
    public function studentDashboard()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)
                          ->orWhere('email', $user->email)
                          ->with(['classes.subjects', 'classes.teacher', 'subjects', 'grades.subject', 'comments'])
                          ->first();

        if (!$student) {
            return redirect('/home')->with('error', 'No student record found.');
        }

        return view('students.dashboard', compact('student'));
    }

    // Show Add Form
    public function showAddForm()
    {
        return view('students.add');
    }

    // Store Student
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

        return redirect()->route('students.index')->with('success', 'Student Added!');
    }

    // Show Edit Form
    public function showEditForm($id)
    {
        $student = Student::find($id);
        if (!$student) return redirect()->route('students.index')->with('error', 'Not found!');
        return view('students.edit', compact('student'));
    }

    // Update Student
    public function updateStudent(StudentRequest $request, $id)
    {
        $student = Student::find($id);
        if (!$student) return redirect()->route('students.index')->with('error', 'Not found!');

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

        return redirect()->route('students.index')->with('success', 'Student Updated!');
    }

    // Delete Student
    public function deleteStudent($id)
    {
        $student = Student::find($id);
        if (!$student) return redirect()->route('students.index')->with('error', 'Not found!');

        if ($student->image && Storage::disk('public')->exists($student->image)) {
            Storage::disk('public')->delete($student->image);
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student Deleted!');
    }

    // Search
    public function search(Request $request)
    {
        $query = Student::query();

        if ($request->filled('name')) $query->where('name', 'like', '%' . $request->name . '%');
        if ($request->filled('email')) $query->where('email', 'like', '%' . $request->email . '%');
        if ($request->filled('gender')) $query->where('gender', $request->gender);
        if ($request->filled('status')) $query->where('status', $request->status);

        $students = $query->paginate(10, ['*'], 'students_page')->appends($request->all());
        $teachers = Teachers::with(['user', 'classes'])->paginate(10, ['*'], 'teachers_page');

        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $inactiveStudents = Student::where('status', 'inactive')->count();
        $pendingStudents = Student::where('status', 'pending')->count();
        $totalTeachers = Teachers::count();
        $totalClasses = Classes::count();
        $totalSubjects = Subject::count();

        return view('students.index', compact(
            'students', 'teachers',
            'totalStudents', 'activeStudents', 'inactiveStudents', 'pendingStudents',
            'totalTeachers', 'totalClasses', 'totalSubjects'
        ));
    }
}