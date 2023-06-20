<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{User, Lecture, Course};
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\UserRole;

class DeleteLectionsApiTest extends TestCase
{
    use RefreshDatabase;

    private $lecture_url;
    private $student;
    private $course;
    private $lection;
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
        $this->lection = \App\Models\Lecture::factory()->create([
            'course_id' => $this->course->id,
            'author_id' => $this->lecturer->id,
        ]);
        $this->student = \App\Models\User::factory()->create([
            'role' => UserRole::STUDENT
        ]);
        $this->lecture_url = route('delete.lecture', ['id' => $this->lection->id]);
    }

    public function tearDown(): void
    {
        $this->refreshApplication();
    }

    public function test_delete_lecture()
    {
        $this->actingAs($this->lecturer);
        $response = $this->deleteJson($this->lecture_url);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['message' => __('lection.deleted')]);
    }

    public function test_student_delete_lecture()
    {
        $this->actingAs($this->student);
        $response = $this->deleteJson($this->lecture_url);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_unauthorized_delete_lecture()
    {
        $response = $this->deleteJson($this->lecture_url);

        $response
            ->assertJsonFragment(['error' => __('authorize.unauthorized')])
            ->assertStatus(400);
    }
}
