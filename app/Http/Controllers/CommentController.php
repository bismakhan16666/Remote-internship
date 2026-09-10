<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teachers;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Add comment to Student
    public function addStudentComment(Request $request, $studentId)
    {
        $request->validate(['comment' => 'required|string']);

        $student = Student::findOrFail($studentId);
        $student->comments()->create([
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Comment added!');
    }

    // Add comment to Teacher
    public function addTeacherComment(Request $request, $teacherId)
    {
        $request->validate(['comment' => 'required|string']);

        $teacher = Teachers::findOrFail($teacherId);
        $teacher->comments()->create([
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Comment added!');
    }

    // Show comment with owner
    public function show($id)
    {
        $comment = Comment::with('commentable')->findOrFail($id);

        return response()->json([
            'comment' => $comment->comment,
            'owner_type' => class_basename($comment->commentable_type),
            'owner' => $comment->commentable,
        ]);
    }
}