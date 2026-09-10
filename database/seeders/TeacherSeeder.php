<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teachers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        //  updateOrCreate - Agar exist karta hai toh update, warna create
        $user = User::updateOrCreate(
            ['email' => 'ali@gmail.com'],  // Search condition
            [
                'name' => 'Ali Ahmed',
                'password' => Hash::make('password'),
                'user_type' => 'teacher',
            ]
        );

        //  updateOrCreate for Teacher
        Teachers::updateOrCreate(
            ['user_id' => $user->id],  // Search condition
            [
                'name' => 'Ali Ahmed',
                'phone' => '0300-1234567',
            ]
        );

        $this->command->info('Teacher seeded successfully!');
    }
}