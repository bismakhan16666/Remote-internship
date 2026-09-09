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
        'image'
    ];

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
}