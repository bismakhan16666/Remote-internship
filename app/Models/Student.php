<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'age',
        'date_of_birth',
        'gender',
        'user_id',
        'score',
        'status',
        'image',
        'class_id' 
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeHighScorers($query)
    {
        return $query->where('score', '>', 80);
    }

    public function scopeAgeGreaterThan($query, $age)
    {
        return $query->where('age', '>', $age);
    }

    //  One-to-One (Inverse): Student belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //  One-to-Many (Inverse): Student belongs to Class
    // Method name 'class' reserved hai, isliye 'classes' kar diya
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    //  One-to-Many: Student has many Grades
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    //  Many-to-Many: Student has many Subjects (via grades pivot)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'grades')
                    ->withPivot('grade')
                    ->withTimestamps();
    }

    //  Polymorphic: Student has many Comments
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}