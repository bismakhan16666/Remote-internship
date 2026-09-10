<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'grade'
    ];

    //  One-to-Many (Inverse): Grade belongs to Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    //  One-to-Many (Inverse): Grade belongs to Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}