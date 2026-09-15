<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //  Many-to-Many: Subject has many Classes
    public function classes()
    {
        return $this->belongsToMany(
            Classes::class,
            'class_subject',
            'subject_id',    // Subject ki foreign key (pivot mein)
            'class_id'       // Classes ki foreign key (pivot mein)
        )->withTimestamps();
    }

    //  Many-to-Many: Subject has many Students (via grades)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'grades')
                    ->withPivot('grade')
                    ->withTimestamps();
    }
}