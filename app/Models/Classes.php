<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'teacher_id',
        'name',
        'description'
    ];

    // ============================================
    //  RELATIONSHIPS
    // ============================================

    // One-to-Many (Inverse): Class belongs to Teacher
    public function teacher()
    {
        return $this->belongsTo(Teachers::class, 'teacher_id');
    }

    // One-to-Many: Class has many Students
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    //  Many-to-Many: Class has many Subjects
    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'class_subject',
            'class_id',      // Foreign key for Classes in pivot table
            'subject_id'     // Foreign key for Subject in pivot table
        )->withTimestamps();
    }
}