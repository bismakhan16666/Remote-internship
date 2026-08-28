<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //Lec 24
            'name'=>$this->faker->name(),
            'email'=>$this->faker->email(),
            'age'=>$this->faker->numberBetween(10,25),
            'date_of_birth'=>$this->faker->date('Y-m-d'), 
            'gender'=>$this->faker->randomElements(['m','f']),  
            
        ];
    }
}
