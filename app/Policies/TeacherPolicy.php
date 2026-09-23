<?php

namespace App\Policies;

use App\Models\Teachers;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any teachers.
     * Admin only
     */
    public function viewAny(User $user)
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can view a specific teacher.
     * Admin + Teacher (own record)
     */
    public function view(User $user, Teachers $teacher)
    {
        if ($user->user_type === 'admin') {
            return true;
        }

        if ($user->user_type === 'teacher') {
            return $teacher->user_id === $user->id || $teacher->email === $user->email;
        }

        return false;
    }

    /**
     * Determine whether the user can create a teacher.
     * Admin only
     */
    public function create(User $user)
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can update a teacher.
     * Admin only
     */
    public function update(User $user, Teachers $teacher)
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can delete a teacher.
     * Admin only
     */
    public function delete(User $user, Teachers $teacher)
    {
        return $user->user_type === 'admin';
    }
}