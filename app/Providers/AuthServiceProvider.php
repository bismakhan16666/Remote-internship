<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // ============================================
        // GATES — Role-based permissions
        // ============================================

        // Admin: Sab kuch kar sakta hai
        Gate::define('is-admin', function (User $user) {
            return $user->user_type === 'admin';
        });

        // Teacher: Sirf apne students dekh sakta hai
        Gate::define('is-teacher', function (User $user) {
            return $user->user_type === 'teacher';
        });

        // Student: Sirf apna dashboard
        Gate::define('is-student', function (User $user) {
            return $user->user_type === 'student';
        });

        // ============================================
        // MANAGE STUDENTS (Add, Edit, Delete)
        // Sirf Admin
        // ============================================
        Gate::define('manage-students', function (User $user) {
            return $user->user_type === 'admin';
        });

        // ============================================
        // MANAGE TEACHERS (Add, Edit, Delete)
        // Sirf Admin
        // ============================================
        Gate::define('manage-teachers', function (User $user) {
            return $user->user_type === 'admin';
        });

        // ============================================
        // VIEW STUDENTS
        // Admin + Teacher
        // ============================================
        Gate::define('view-students', function (User $user) {
            return in_array($user->user_type, ['admin', 'teacher']);
        });

        // ============================================
        // ADD COMMENT (Remarks)
        // Admin + Teacher
        // ============================================
        Gate::define('add-comment', function (User $user) {
            return in_array($user->user_type, ['admin', 'teacher']);
        });
    }
}