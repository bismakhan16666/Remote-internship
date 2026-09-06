<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;   // ✅ User model import karein

class StudentFactory extends Factory
{
    protected $model = \App\Models\Student::class;

    public function definition()
    { //Lec 27
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'age' => $this->faker->numberBetween(18, 30),
            'date_of_birth' => $this->faker->date('Y-m-d', '2006-01-01'),
            'gender' => $this->faker->randomElement(['m', 'f']),
            'user_id' => 1,   
            // 'user_id' => User::factory(),  
            'score' => $this->faker->numberBetween(0, 100),//Lec 31
        ];
    }
}