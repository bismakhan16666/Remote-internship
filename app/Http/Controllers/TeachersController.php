<?php

namespace App\Http\Controllers;

use App\Models\Teachers;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    // ============================================
    // ✅ TEACHER DASHBOARD
    // ============================================
    public function dashboard()
    {
        $user = Auth::user();
        
        // Teacher record find karein
        $teacher = Teachers::where('user_id', $user->id)
                           ->orWhere('name', $user->name)
                           ->with([
                               'classes.students',      // Classes + Students
                               'classes.subjects',      // Classes + Subjects
                               'comments'               // Comments on teacher
                           ])
                           ->first();

        if (!$teacher) {
            return redirect('/home')->with('error', 'No teacher record found. Contact admin.');
        }

        // Stats
        $totalClasses = $teacher->classes->count();
        $totalStudents = Student::whereIn('class_id', $teacher->classes->pluck('id'))->count();
        $totalSubjects = Subject::whereHas('classes', function($q) use ($teacher) {
            $q->whereIn('classes.id', $teacher->classes->pluck('id'));
        })->count();

        // Students list (with class info)
        $students = Student::whereIn('class_id', $teacher->classes->pluck('id'))
                           ->with(['classes', 'subjects'])
                           ->paginate(10);

        return view('teachers.dashboard', compact(
            'teacher',
            'totalClasses',
            'totalStudents',
            'totalSubjects',
            'students'
        ));
    }

    // ============================================
    // ✅ SHOW CLASS DETAILS (Teacher's Class)
    // ============================================
    public function showClass($id)
    {
        $class = Classes::with(['students', 'subjects', 'teacher'])->findOrFail($id);

        return view('teachers.class-details', compact('class'));
    }

    // ============================================
    // ✅ SHOW STUDENT DETAILS (Teacher's Student)
    // ============================================
    public function showStudent($id)
    {
        $student = Student::with([
            'classes',
            'subjects',
            'grades.subject',
            'comments'
        ])->findOrFail($id);

        return view('teachers.student-details', compact('student'));
    }

    // ============================================
    // ✅ ADD COMMENT/REMARK TO STUDENT
    // ============================================
    public function addComment(Request $request, $studentId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $student = Student::findOrFail($studentId);
        
        $student->comments()->create([
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Remark added successfully!');
    }
}