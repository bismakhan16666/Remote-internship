<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Teachers;   
use App\Models\Classes; 

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //  One-to-One: User has one Student
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    //  One-to-One: User has one Teacher
    public function teacher()
    {
        return $this->hasOne(Teachers::class);
    }
    //  Has One Through: User has one Class (through Teacher)
    public function class()
    {
        return $this->hasOneThrough(
            Classes::class,     // Final Model (jo chahiye)
            Teachers::class,    // Through Model (bridge)
            'user_id',          // Foreign key on teachers table (linking to users)
            'teacher_id',       // Foreign key on classes table (linking to teachers)
            'id',               // Local key on users table
            'id'                // Local key on teachers table
        );
    }
    // Has Many Through: User has many Classes (through Teacher)
    public function classes()
    {
        return $this->hasManyThrough(
        \App\Models\Classes::class,     
        \App\Models\Teachers::class,     // Through Model (bridge)
            'user_id',          // Foreign key on teachers table (linking to users)
            'teacher_id',       // Foreign key on classes table (linking to teachers)
            'id',               // Local key on users table
            'id'                // Local key on teachers table
        );
    }
}


