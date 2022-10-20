<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\UserRole;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CitySeeder::class);
        $this->call(UniversitySeeder::class);

        \App\Models\User::factory()->create([
            'name' => 'Admnin',
            'last_name' => 'Admnin',
            'email' => 'admin@example.com',
            'password' => bcrypt('Admin1Admin1'),
            'phone' => '0000000000',
            'city' => null,
            'university' => null,
            'role' => UserRole::ADMIN
        ]);

        $lecturer = \App\Models\User::factory()->create([
             'name' => 'Lecturer',
             'last_name' => 'Lecturer',
             'email' => 'lecturer@example.com',
             'password' => bcrypt('Lecturer1'),
             'phone' => '111111111111',
             'city' => null,
             'university' => null,
             'role' => UserRole::LECTURER
         ]);

        $student = \App\Models\User::factory()->create([
            'name' => 'Student',
            'last_name' => 'Student',
            'email' => 'student@example.com',
            'password' => bcrypt('Student1'),
            'phone' => '222222222222',
            'city' => null,
            'university' => null,
            'role' => UserRole::STUDENT
        ]);

        \App\Models\User::factory(9)->create([
            'role' => UserRole::STUDENT
        ]);

        \App\Models\Course::factory(3)->create([
            'author_id' => $lecturer->id
        ])->each(function($course) use ($student) {
            \App\Models\Lecture::factory(3)->create([
                'course_id' => $course->id,
                'author_id' => $course->author_id,
            ])->each(function($lecture) use ($student) {
                $task = \App\Models\Task::factory()->create([
                    'author_id' => $lecture->author_id,
                    'lecture_id' => $lecture->id,
                    'course_id' => $lecture->course_id,
                ]);
                $task->users()->attach(\App\Models\User::find($student->id));
            });
        });
    }
}
