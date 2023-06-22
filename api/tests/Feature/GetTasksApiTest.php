<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{User, Course, Lecture, Task};
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\UserRole;

class GetTasksApiTest extends TestCase
{
    use RefreshDatabase;

    private $id;
    private $url;
    private $admin;
    private $lecturer;
    private $student;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'role' => UserRole::ADMIN
        ]);
        $this->lecturer = User::factory()->create([
            'role' => UserRole::LECTURER
        ]);
        $this->student = User::factory()->create([
            'role' => UserRole::STUDENT
        ]);
        $student = $this->student;
        Course::factory(3)->create([
            'author_id' => $this->lecturer->id
        ])->each(function($course) use ($student) {
            Lecture::factory(3)->create([
                'course_id' => $course->id,
                'author_id' => $course->author_id,
            ])->each(function($lecture) use ($student) {
                $task = Task::factory()->create([
                    'author_id' => $lecture->author_id,
                    'course_id' => $lecture->course_id,
                    'lecture_id' => $lecture->id
                ]);
                $this->id = $task->id;
                $task->users()->attach(User::find($student->id));
            });
        });
        $this->url = route('get.tasks');
    }

    public function test_getting_users_by_lecturer()
    {
        $this->actingAs($this->lecturer);
        $response = $this->getJson($this->url);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $this->id]);
    }

    public function test_getting_users_by_admin()
    {
        $this->actingAs($this->admin);
        $response = $this->getJson($this->url);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_getting_users_by_student()
    {
        $this->actingAs($this->student);
        $response = $this->getJson($this->url);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_unauthorized_user()
    {
        $response = $this->getJson($this->url);

        $response
            ->assertJsonFragment(['error' => __('authorize.unauthorized')])
            ->assertStatus(400);
    }

}
