<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teachers extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'qualification',
        'subject_specialization',
        'experience',
        'image',
        'status'
    ];

    //  One-to-One: Teacher belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //  One-to-Many: Teacher has many Classes
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