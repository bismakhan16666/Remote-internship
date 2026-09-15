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
        $teachers = [
            [
                'name' => 'Ali Ahmed',
                'email' => 'ali@gmail.com',
                'phone' => '0300-1234567',
                'qualification' => 'M.Sc Mathematics',
                'subject_specialization' => 'Mathematics',
                'experience' => '5 years',
                'status' => 'active',
            ],
            [
                'name' => 'Sara Khan',
                'email' => 'sara@gmail.com',
                'phone' => '0301-2345678',
                'qualification' => 'M.A English',
                'subject_specialization' => 'English',
                'experience' => '3 years',
                'status' => 'active',
            ],
            [
                'name' => 'Usman Ali',
                'email' => 'usman@gmail.com',
                'phone' => '0302-3456789',
                'qualification' => 'M.Sc Physics',
                'subject_specialization' => 'Physics',
                'experience' => '7 years',
                'status' => 'active',
            ],
            [
                'name' => 'Fatima Noor',
                'email' => 'fatima@gmail.com',
                'phone' => '0303-4567890',
                'qualification' => 'M.Sc Chemistry',
                'subject_specialization' => 'Chemistry',
                'experience' => '4 years',
                'status' => 'active',
            ],
            [
                'name' => 'Hassan Raza',
                'email' => 'hassan@gmail.com',
                'phone' => '0304-5678901',
                'qualification' => 'M.Sc Biology',
                'subject_specialization' => 'Biology',
                'experience' => '6 years',
                'status' => 'active',
            ],
        ];

        foreach ($teachers as $teacherData) {

            // 1. User Account Create/Update
            $user = User::updateOrCreate(
                ['email' => $teacherData['email']],
                [
                    'name' => $teacherData['name'],
                    'password' => Hash::make('password'),
                    'user_type' => 'teacher',
                ]
            );

            // 2. Teacher Record Create/Update
            Teachers::updateOrCreate(          //  Plural
                ['email' => $teacherData['email']],
                [
                    'user_id' => $user->id,
                    'name' => $teacherData['name'],
                    'email' => $teacherData['email'],
                    'phone' => $teacherData['phone'],
                    'qualification' => $teacherData['qualification'],
                    'subject_specialization' => $teacherData['subject_specialization'],
                    'experience' => $teacherData['experience'],
                    'status' => $teacherData['status'],
                ]
            );
        }

        $this->command->info(' Teachers seeded successfully! Total: ' . count($teachers));
    }
}