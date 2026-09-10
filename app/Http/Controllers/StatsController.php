<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Teachers;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    // ============================================
    // Dashboard with All Aggregate Stats
    // ============================================
    public function dashboard()
    {
        //  Basic Counts
        $totalUsers = User::count();
        $totalStudents = Student::count();
        $totalTeachers = Teachers::count();
        $totalClasses = Classes::count();
        $totalSubjects = Subject::count();
        $totalGrades = Grade::count();

        //  Score Aggregates
        $totalScore = Student::sum('score');
        $avgScore = Student::avg('score');
        $maxScore = Student::max('score');
        $minScore = Student::min('score');

        //  Age Aggregates
        $avgAge = Student::avg('age');
        $maxAge = Student::max('age');
        $minAge = Student::min('age');

        //  Status Counts
        $activeStudents = Student::where('status', 'active')->count();
        $inactiveStudents = Student::where('status', 'inactive')->count();
        $pendingStudents = Student::where('status', 'pending')->count();

        //  Relationship Counts (withCount)
        $teachersWithClassCount = Teachers::withCount('classes')->get();
        $classesWithStudentCount = Classes::withCount('students')->get();
        $studentsWithSubjectCount = Student::withCount('subjects')->get();
        $teachersWithCommentCount = Teachers::withCount('comments')->get();
        $studentsWithCommentCount = Student::withCount('comments')->get();

        //  Relationship Aggregates (withSum, withAvg, etc.)
        $studentsWithGradeStats = Student::withSum('grades', 'grade')
                                         ->withAvg('grades', 'grade')
                                         ->withMax('grades', 'grade')
                                         ->withMin('grades', 'grade')
                                         ->get();

        //  Multiple Counts at Once
        $teachersWithMultipleCounts = Teachers::withCount([
            'classes',
            'comments'
        ])->get();

        return view('stats.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'totalSubjects',
            'totalGrades',
            'totalScore',
            'avgScore',
            'maxScore',
            'minScore',
            'avgAge',
            'maxAge',
            'minAge',
            'activeStudents',
            'inactiveStudents',
            'pendingStudents',
            'teachersWithClassCount',
            'classesWithStudentCount',
            'studentsWithSubjectCount',
            'teachersWithCommentCount',
            'studentsWithCommentCount',
            'studentsWithGradeStats',
            'teachersWithMultipleCounts'
        ));
    }

    // ============================================
    // Basic Aggregate Functions
    // ============================================
    public function basicAggregates()
    {
        $data = [
            // Counts
            'total_students' => Student::count(),
            'total_teachers' => Teachers::count(),
            'total_classes' => Classes::count(),
            'total_subjects' => Subject::count(),

            // Sum
            'total_score' => Student::sum('score'),
            'total_grade' => Grade::sum('grade'),

            // Avg
            'avg_score' => Student::avg('score'),
            'avg_age' => Student::avg('age'),
            'avg_grade' => Grade::avg('grade'),

            // Max
            'max_score' => Student::max('score'),
            'max_age' => Student::max('age'),
            'max_grade' => Grade::max('grade'),

            // Min
            'min_score' => Student::min('score'),
            'min_age' => Student::min('age'),
            'min_grade' => Grade::min('grade'),
        ];

        return response()->json($data);
    }

    // ============================================
    // Relationship Counts
    // ============================================
    public function relationshipCounts()
    {
        // Teacher with classes count
        $teachers = Teachers::withCount('classes')->get();

        // Class with students count
        $classes = Classes::withCount('students')->get();

        // Student with subjects count
        $students = Student::withCount('subjects')->get();

        return response()->json([
            'teachers' => $teachers,
            'classes' => $classes,
            'students' => $students,
        ]);
    }

    // ============================================
    // Advanced Aggregates with Conditions
    // ============================================
    public function advancedAggregates()
    {
        // Count active students per class
        $classes = Classes::withCount(['students' => function ($query) {
            $query->where('status', 'active');
        }])->get();

        // Student with high grades sum (grade > 80)
        $students = Student::withSum(['grades' => function ($query) {
            $query->where('grade', '>', 80);
        }], 'grade')->get();

        return response()->json([
            'classes_with_active_students' => $classes,
            'students_with_high_grades' => $students,
        ]);
    }

    // ============================================
    // Aggregates with Aliases
    // ============================================
    public function aliasedAggregates()
    {
        $teachers = Teachers::withCount([
            'classes as total_classes',
            'comments as total_comments'
        ])->get();

        $students = Student::withSum('grades as total_grade_points', 'grade')
                          ->withAvg('grades as average_grade', 'grade')
                          ->get();

        return response()->json([
            'teachers' => $teachers,
            'students' => $students,
        ]);
    }

    // ============================================
    // Direct Relationship Aggregates
    // ============================================
    public function directAggregates($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        return response()->json([
            'student' => $student->name,
            'total_grades' => $student->grades()->count(),
            'total_grade_points' => $student->grades()->sum('grade'),
            'average_grade' => $student->grades()->avg('grade'),
            'max_grade' => $student->grades()->max('grade'),
            'min_grade' => $student->grades()->min('grade'),
            'total_subjects' => $student->subjects()->count(),
        ]);
    }
}