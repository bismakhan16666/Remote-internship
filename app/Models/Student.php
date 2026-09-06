<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
//Lec 31
    protected $fillable = [
        'name',
        'email',
        'age',
        'date_of_birth',
        'gender',
        'user_id',
        'score',  
    ];
}