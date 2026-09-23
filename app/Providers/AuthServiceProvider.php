<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Models
use App\Models\Student;
use App\Models\Teachers;

// Policies
use App\Policies\StudentPolicy;
use App\Policies\TeacherPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Student::class  => StudentPolicy::class,
        Teachers::class => TeacherPolicy::class,
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

        Gate::define('is-admin', function ($user) {
            return $user->user_type === 'admin';
        });

        Gate::define('is-teacher', function ($user) {
            return $user->user_type === 'teacher';
        });

        Gate::define('is-student', function ($user) {
            return $user->user_type === 'student';
        });

        Gate::define('manage-students', function ($user) {
            return $user->user_type === 'admin';
        });

        Gate::define('manage-teachers', function ($user) {
            return $user->user_type === 'admin';
        });

        Gate::define('view-students', function ($user) {
            return in_array($user->user_type, ['admin', 'teacher']);
        });

        Gate::define('add-comment', function ($user) {
            return in_array($user->user_type, ['admin', 'teacher']);
        });
    }
}