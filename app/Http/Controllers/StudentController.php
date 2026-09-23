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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentAddedMail;
use App\Events\StudentAdded;   // <-- Event import

class StudentController extends Controller
{
    // ============================================
    //  ADMIN DASHBOARD
    // ============================================
    public function adminIndex()
    {
        $this->authorize('viewAny', Student::class);

        $students = Cache::remember('students_list_page_' . request('students_page', 1), 600, function () {
            return Student::with(['classes', 'user'])
                          ->paginate(10, ['*'], 'students_page');
        });

        $teachers = Cache::remember('teachers_list_page_' . request('teachers_page', 1), 600, function () {
            return Teachers::with(['user', 'classes'])
                            ->paginate(10, ['*'], 'teachers_page');
        });

        $stats = Cache::remember('dashboard_stats', 600, function () {
            return [
                'totalStudents'    => Student::count(),
                'activeStudents'   => Student::where('status', 'active')->count(),
                'inactiveStudents' => Student::where('status', 'inactive')->count(),
                'pendingStudents'  => Student::where('status', 'pending')->count(),
                'totalTeachers'    => Teachers::count(),
                'totalClasses'     => Classes::count(),
                'totalSubjects'    => Subject::count(),
            ];
        });

        return view('students.index', compact('students', 'teachers', 'stats'));
    }

    // ============================================
    //  STUDENT DASHBOARD
    // ============================================
    public function studentDashboard()
    {
        $user = Auth::user();

        $student = Cache::remember('student_dashboard_' . $user->id, 600, function () use ($user) {
            return Student::where('user_id', $user->id)
                          ->orWhere('email', $user->email)
                          ->with(['classes.subjects', 'classes.teacher', 'subjects', 'grades.subject', 'comments'])
                          ->first();
        });

        if (!$student) {
            abort(404, 'No student record found. Please contact admin.');
        }

        $this->authorize('view', $student);

        return view('students.dashboard', compact('student'));
    }

    // ============================================
    //  SHOW ADD FORM
    // ============================================
    public function showAddForm()
    {
        $this->authorize('create', Student::class);
        session()->flash('info', 'Please fill the form carefully.');
        return view('students.add');
    }

    // ============================================
    //  STORE STUDENT - Event Fire
    // ============================================
    public function storeStudent(StudentRequest $request)
    {
        $this->authorize('create', Student::class);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('students', 'public');
        }

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'score' => $request->score ?? 0,
            'status' => $request->status,
            'user_id' => Auth::id(),
            'image' => $imagePath
        ]);

        // ============================================
        // BEFORE (OLD CODE):
        // ============================================
        // Mail::to(Auth::user()->email)->queue(new StudentAddedMail($student));

        // ============================================
        // AFTER (NEW CODE - EVENT):
        // ============================================
        // Event fire karo - listener automatically chalega
        event(new StudentAdded($student));

        // Clear cache
        Cache::forget('dashboard_stats');
        Cache::flush();

        return redirect()->route('students.index')->with('success', 'Student Added! Event fired.');
    }

    // ============================================
    //  SHOW EDIT FORM
    // ============================================
    public function showEditForm($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Not found!');
        }

        $this->authorize('update', $student);

        return view('students.edit', compact('student'));
    }

    // ============================================
    //  UPDATE STUDENT
    // ============================================
    public function updateStudent(StudentRequest $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Not found!');
        }

        $this->authorize('update', $student);

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

        Cache::forget('student_dashboard_' . $student->user_id);
        Cache::forget('dashboard_stats');
        Cache::flush();

        return redirect()->route('students.index')->with('success', 'Student Updated!');
    }

    // ============================================
    //  DELETE STUDENT
    // ============================================
    public function deleteStudent($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Not found!');
        }

        $this->authorize('delete', $student);

        if ($student->image && Storage::disk('public')->exists($student->image)) {
            Storage::disk('public')->delete($student->image);
        }

        $student->delete();

        Cache::forget('student_dashboard_' . $student->user_id);
        Cache::forget('dashboard_stats');
        Cache::flush();

        return redirect()->route('students.index')->with('success', 'Student Deleted!');
    }

    // ============================================
    //  SEARCH
    // ============================================
    public function search(Request $request)
    {
        $this->authorize('viewAny', Student::class);

        $query = Student::query();

        if ($request->filled('name')) $query->where('name', 'like', '%' . $request->name . '%');
        if ($request->filled('email')) $query->where('email', 'like', '%' . $request->email . '%');
        if ($request->filled('gender')) $query->where('gender', $request->gender);
        if ($request->filled('status')) $query->where('status', $request->status);

        $students = $query->paginate(10, ['*'], 'students_page')->appends($request->all());
        $teachers = Teachers::with(['user', 'classes'])->paginate(10, ['*'], 'teachers_page');

        $stats = Cache::remember('dashboard_stats', 600, function () {
            return [
                'totalStudents'    => Student::count(),
                'activeStudents'   => Student::where('status', 'active')->count(),
                'inactiveStudents' => Student::where('status', 'inactive')->count(),
                'pendingStudents'  => Student::where('status', 'pending')->count(),
                'totalTeachers'    => Teachers::count(),
                'totalClasses'     => Classes::count(),
                'totalSubjects'    => Subject::count(),
            ];
        });

        return view('students.index', compact('students', 'teachers', 'stats'));
    }
}