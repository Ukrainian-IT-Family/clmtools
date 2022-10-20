<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChatWithStudentApiTest extends TestCase
{
    use RefreshDatabase;

    private string $auth_api_url;
    private string $lecturer_chat_api_url;
    private string $lecturer_message_api_url;
    private string $students_by_lecture_api_url;

    private mixed $user_lecturer;
    private mixed $user_student;
    private mixed $course;
    private mixed $lecture;

    private string $auth_token;

    public function setUp(): void
    {
        parent::setUp();

        $this->auth_api_url = 'api/v1/login';
        $this->lecturer_chat_api_url = 'api/v1/lecturer-chat';
        $this->lecturer_message_api_url = 'api/v1/lecturer-message';
        $this->students_by_lecture_api_url = 'api/v1/students-by-lecture';

        $this->user_lecturer = User::factory()->create([
            'name' => 'Lecturer',
            'last_name' => 'User',
            'email' => 'lecturer1@example.com',
            'phone' => '222222222222',
            'password' => Hash::make('Lecturer123456'),
            'profile_image' => 'https://via.placeholder.com/640x480.png',
            'date_birth' => '1988-03-31',
            'graduation_year' => '2008',
            'role' => 'lecturer'
        ]);

        $this->user_student = User::factory()->create([
            'name' => 'Student',
            'last_name' => 'User',
            'email' => 'student1@example.com',
            'phone' => '111111111111',
            'password' => Hash::make('Student123456'),
            'profile_image' => 'https://via.placeholder.com/640x480.png',
            'date_birth' => '1988-03-31',
            'graduation_year' => '2008',
            'role' => 'student'
        ]);

        $this->course = Course::factory()->create([
            'title' => 'Test course',
            'author_id' => $this->user_lecturer->id
        ]);

        $this->lecture = Lecture::factory()->create([
            'title' => 'Magni vel enim dolores.',
            'preview_image' => 'https://via.placeholder.com/600/5F113B/FFFFFF/?text=Lecture',
            'link' => 'https://www.youtube.com/watch?v=USjZcfj8yxE',
            'author_id' => $this->user_lecturer->id,
            'course_id' => $this->course->id,
            'order' => '500'
        ]);

        $lecturerData = [
            "email" => "lecturer1@example.com",
            "password" => "Lecturer123456"
        ];
        $responseAuth = $this->postJson($this->auth_api_url, $lecturerData);
        $this->auth_token = $responseAuth['access_token'];
    }

    public function test_create_lecturer_chat()
    {
        $chatData = [
            "user_id" => $this->user_student->id,
            "lecture_id" => $this->lecture->id
        ];
        $response = $this->postJson($this->lecturer_chat_api_url, $chatData, [
            'Authorization' => 'Bearer ' . $this->auth_token
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "user",
                "lecture",
                "created_at"
            ]);
    }

    public function test_create_lecturer_message()
    {
        $chatData = [
            "user_id" => $this->user_student->id,
            "lecture_id" => $this->lecture->id
        ];
        $this->postJson($this->lecturer_chat_api_url, $chatData, [
            'Authorization' => 'Bearer ' . $this->auth_token
        ]);

        $messageData = [
            "lecture_id" => $this->lecture->id,
            "body" => "test message",
            "student_id" => $this->user_student->id,
        ];
        $response = $this->postJson($this->lecturer_message_api_url, $messageData, [
            'Authorization' => 'Bearer ' . $this->auth_token
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "user",
                "chat",
                "body",
                "file_url",
                "created_at"
            ]);
    }

    public function test_get_students_by_lecture()
    {
        $response = $this->getJson($this->students_by_lecture_api_url . '?lecture_id=' . $this->lecture->id . '', [
            'Authorization' => 'Bearer ' . $this->auth_token
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    "id",
                    "avatar",
                    "email",
                    "name",
                    "last_name",
                    "date_birth",
                    "phone",
                    "email_verified_at",
                    "city",
                    "university",
                    "graduation_year",
                    "role",
                    "course"
                ]
            ]);
    }
}
