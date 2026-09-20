<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teachers;
use App\Models\Classes;
use App\Models\Subject;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // ============================================
    //  ADMIN DASHBOARD
    // ============================================
    public function adminIndex()
    {
        // Sirf Admin + Teacher dekh sakte hain
        if (!Gate::allows('view-students')) {
            abort(403, 'You are not allowed to view students.');
        }

        $students = Student::with(['classes', 'user'])
                           ->paginate(10, ['*'], 'students_page');
        
        $teachers = Teachers::with(['user', 'classes'])
                            ->paginate(10, ['*'], 'teachers_page');

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

    // ============================================
    //  STUDENT DASHBOARD
    // ============================================
    public function studentDashboard()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)
                          ->orWhere('email', $user->email)
                          ->with(['classes.subjects', 'classes.teacher', 'subjects', 'grades.subject', 'comments'])
                          ->first();

        if (!$student) {
            abort(404, 'No student record found. Please contact admin.');
        }

        return view('students.dashboard', compact('student'));
    }

    // ============================================
    //  SHOW ADD FORM — Sirf Admin
    // ============================================
    public function showAddForm()
    {
        if (!Gate::allows('manage-students')) {
            abort(403, 'Only admin can add students.');
        }

        return view('students.add');
    }

    // ============================================
    //  STORE STUDENT — Sirf Admin
    // ============================================
    public function storeStudent(StudentRequest $request)
    {
        if (!Gate::allows('manage-students')) {
            abort(403, 'Only admin can add students.');
        }

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

    // ============================================
    //  SHOW EDIT FORM — Sirf Admin
    // ============================================
    public function showEditForm($id)
    {
        if (!Gate::allows('manage-students')) {
            abort(403, 'Only admin can edit students.');
        }

        $student = Student::find($id);
        if (!$student) return redirect()->route('students.index')->with('error', 'Not found!');
        return view('students.edit', compact('student'));
    }

    // ============================================
    //  UPDATE STUDENT — Sirf Admin
    // ============================================
    public function updateStudent(StudentRequest $request, $id)
    {
        if (!Gate::allows('manage-students')) {
            abort(403, 'Only admin can edit students.');
        }

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

    // ============================================
    //  DELETE STUDENT — Sirf Admin
    // ============================================
    public function deleteStudent($id)
    {
        if (!Gate::allows('manage-students')) {
            abort(403, 'Only admin can delete students.');
        }

        $student = Student::find($id);
        if (!$student) return redirect()->route('students.index')->with('error', 'Not found!');

        if ($student->image && Storage::disk('public')->exists($student->image)) {
            Storage::disk('public')->delete($student->image);
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student Deleted!');
    }

    // ============================================
    //  SEARCH
    // ============================================
    public function search(Request $request)
    {
        if (!Gate::allows('view-students')) {
            abort(403, 'You are not allowed to search students.');
        }

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