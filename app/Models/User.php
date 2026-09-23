<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;   // 👈 Already imported
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Teachers;
use App\Models\Classes;

// ============================================
// BEFORE (OLD CODE):
// ============================================
// class User extends Authenticatable
// {
//     use HasApiTokens, HasFactory, Notifiable;

// ============================================
// AFTER (NEW CODE — WITH MustVerifyEmail):
// ============================================
// WHAT'S NEW:
// 1. implements MustVerifyEmail — email verification enable
// 2. Iske baad Laravel automatically verification email bhejega
// 3. User ko verify karna zaroori hoga
// ============================================

class User extends Authenticatable implements MustVerifyEmail   // 👈 Ye add kiya
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
        'user_type',   // 👈 Ye add karo (registration me use ho raha hai)
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

    // ============================================
    // RELATIONSHIPS
    // ============================================

    // One-to-One: User has one Student
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // One-to-One: User has one Teacher
    public function teacher()
    {
        return $this->hasOne(Teachers::class);
    }

    // Has One Through: User has one Class (through Teacher)
    public function class()
    {
        return $this->hasOneThrough(
            Classes::class,
            Teachers::class,
            'user_id',
            'teacher_id',
            'id',
            'id'
        );
    }

    // Has Many Through: User has many Classes (through Teacher)
    public function classes()
    {
        return $this->hasManyThrough(
            \App\Models\Classes::class,
            \App\Models\Teachers::class,
            'user_id',
            'teacher_id',
            'id',
            'id'
        );
    }
}