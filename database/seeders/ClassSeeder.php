<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Teachers;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run()
    {
        // Create 3 classes for each teacher
        $teachers = Teachers::all();

        foreach ($teachers as $teacher) {
            Classes::updateOrCreate(
                ['name' => 'Math 101 - ' . $teacher->id],
                [
                    'teacher_id' => $teacher->id,
                    'description' => 'Basic Mathematics'
                ]
            );

            Classes::updateOrCreate(
                ['name' => 'Science 101 - ' . $teacher->id],
                [
                    'teacher_id' => $teacher->id,
                    'description' => 'Basic Science'
                ]
            );
        }
    }
}