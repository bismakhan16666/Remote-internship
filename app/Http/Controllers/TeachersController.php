<?php

namespace App\Http\Controllers;

use App\Models\Teachers;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeachersController extends Controller
{
    // ============================================
    // TEACHER DASHBOARD
    // ============================================
    public function dashboard()
    {
        $user = Auth::user();
        $teacher = Teachers::where('user_id', $user->id)
                           ->orWhere('email', $user->email)
                           ->with(['classes.students', 'classes.subjects', 'comments'])
                           ->first();

        if (!$teacher) {
            return redirect('/students')->with('info', 'No teacher record found.');
        }

        $totalClasses = $teacher->classes->count();
        $totalStudents = Student::whereIn('class_id', $teacher->classes->pluck('id'))->count();
        $totalSubjects = Subject::whereHas('classes', function($q) use ($teacher) {
            $q->whereIn('classes.id', $teacher->classes->pluck('id'));
        })->count();

        $students = Student::whereIn('class_id', $teacher->classes->pluck('id'))
                           ->with(['classes', 'subjects'])
                           ->paginate(10);

        return view('teachers.dashboard', compact('teacher', 'totalClasses', 'totalStudents', 'totalSubjects', 'students'));
    }

    // ============================================
    // TEACHER KE APNE STUDENTS
    // ============================================
    public function myStudents()
    {
        $user = Auth::user();
        $teacher = Teachers::where('user_id', $user->id)
                           ->orWhere('email', $user->email)
                           ->first();

        if (!$teacher) {
            return redirect('/home')->with('error', 'No teacher record found.');
        }

        $classIds = $teacher->classes->pluck('id');
        
        $students = Student::whereIn('class_id', $classIds)
                           ->with(['classes', 'subjects'])
                           ->paginate(10);

        $totalStudents = Student::whereIn('class_id', $classIds)->count();
        $totalClasses = $teacher->classes->count();

        return view('teachers.my-students', compact('teacher', 'students', 'totalStudents', 'totalClasses'));
    }

    // Show Class Details
    public function showClass($id)
    {
        $class = Classes::with(['students', 'subjects', 'teacher'])->findOrFail($id);
        return view('teachers.class-details', compact('class'));
    }

    // Show Student Details
    public function showStudent($id)
    {
        $student = Student::with(['classes', 'subjects', 'grades.subject', 'comments'])->findOrFail($id);
        return view('teachers.student-details', compact('student'));
    }

    // Add Comment
    public function addComment(Request $request, $studentId)
    {
        $request->validate(['comment' => 'required|string|max:1000']);
        $student = Student::findOrFail($studentId);
        $student->comments()->create(['comment' => $request->comment]);
        return redirect()->back()->with('success', 'Remark added!');
    }

    // Show Add Teacher Form
    public function create()
    {
        return view('teachers.add');
    }

    // Store Teacher
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'subject_specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teachers', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'user_type' => 'teacher',
        ]);

        Teachers::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'qualification' => $request->qualification,
            'subject_specialization' => $request->subject_specialization,
            'experience' => $request->experience,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('students.index')->with('success', 'Teacher Added Successfully!');
    }

    // Show Edit Form
    public function edit($id)
    {
        $teacher = Teachers::findOrFail($id);
        return view('teachers.edit', compact('teacher'));
    }

    // Update Teacher
    public function update(Request $request, $id)
    {
        $teacher = Teachers::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'subject_specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = $teacher->image;
        if ($request->hasFile('image')) {
            if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
                Storage::disk('public')->delete($teacher->image);
            }
            $imagePath = $request->file('image')->store('teachers', 'public');
        }

        $teacher->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'qualification' => $request->qualification,
            'subject_specialization' => $request->subject_specialization,
            'experience' => $request->experience,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('students.index')->with('success', 'Teacher Updated Successfully!');
    }

    // Delete Teacher
    public function destroy($id)
    {
        $teacher = Teachers::findOrFail($id);

        if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
            Storage::disk('public')->delete($teacher->image);
        }

        if ($teacher->user) {
            $teacher->user->delete();
        }

        $teacher->delete();

        return redirect()->route('students.index')->with('success', 'Teacher Deleted Successfully!');
    }
}