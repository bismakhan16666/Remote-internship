<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any students.
     * Admin + Teacher
     */
    public function viewAny(User $user)
    {
        return in_array($user->user_type, ['admin', 'teacher']);
    }

    /**
     * Determine whether the user can view a specific student.
     * Admin + Teacher + Owner Student
     */
    public function view(User $user, Student $student)
    {
        // Admin + Teacher can view any student
        if (in_array($user->user_type, ['admin', 'teacher'])) {
            return true;
        }

        // Student can only view their own record (by user_id OR email)
        if ($user->user_type === 'student') {
            return $student->user_id === $user->id || $student->email === $user->email;
        }

        return false;
    }

    /**
     * Determine whether the user can create a student.
     * Admin only
     */
    public function create(User $user)
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can update a student.
     * Admin only — Student CANNOT edit their own record
     */
    public function update(User $user, Student $student)
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can delete a student.
     * Admin only
     */
    public function delete(User $user, Student $student)
    {
        return $user->user_type === 'admin';
    }
}