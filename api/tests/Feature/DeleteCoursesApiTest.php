<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{User, Course};
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\UserRole;

class DeleteCoursesApiTest extends TestCase
{
    use RefreshDatabase;

    private $course_url;
    private $student;
    private $course;
    private $lecturer;

    public function setUp(): void
    {
        parent::setUp();
        $this->lecturer = \App\Models\User::factory()->create([
            'role' => UserRole::LECTURER
        ]);
        $this->course = \App\Models\Course::factory()->create([
            'author_id' => $this->lecturer->id
        ]);
        $this->student = \App\Models\User::factory()->create([
            'role' => UserRole::STUDENT
        ]);
        $this->course_url = route('delete.course', $this->course->id);
    }

    public function tearDown(): void
    {
        $this->refreshApplication();
    }

    public function test_delete_course()
    {
        $this->actingAs($this->lecturer);
        $response = $this->deleteJson($this->course_url);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['message' => __('course.deleted')]);
    }

    public function test_student_delete_course()
    {
        $this->actingAs($this->student);
        $response = $this->deleteJson($this->course_url);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_unauthorized_delete_course()
    {
        $response = $this->deleteJson($this->course_url);

        $response
            ->assertJsonFragment(['error' => __('authorize.unauthorized')])
            ->assertStatus(400);
    }
}
