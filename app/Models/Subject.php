<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //  Many-to-Many: Subject belongs to many Classes
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_subject')
                    ->withTimestamps();
    }
}