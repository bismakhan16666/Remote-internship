<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teachers extends Model
{
    use HasFactory;

    /**
     *  Table name specify karein
     * Kyunki model ka naam plural hai, Laravel khud "teachers" table dhoondhega
     * Lekin safe rehne ke liye explicitly likh dein
     */
    protected $table = 'teachers';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'phone'
    ];

    // ============================================
    //  RELATIONSHIPS
    // ============================================

    /**
     * One-to-One (Inverse): Teachers belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * One-to-Many: Teachers has many Classes
     */
    public function classes()
    {
        return $this->hasMany(Classes::class, 'teacher_id');
    }
     //  Polymorphic: Teacher has many Comments
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
