<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{User, Lecture, Course};
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\UserRole;

class EditLectionsApiTest extends TestCase
{
    use RefreshDatabase;

    private $lecture_url;
    private $title;
    private $student;
    private $course;
    private $lection;
    private $link;
    private $lecturer;

    public function setUp(): void
    {
        parent::setUp();

        $this->title = 'Test title for manual testing';
        $this->link = 'https://www.youtube.com/watch?v=ZUMQEkoF1_c';
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
        $this->lecture_url = route('edit.lecture', ['id' => $this->lection->id]);
    }

    public function tearDown(): void
    {
        $this->refreshApplication();
    }

    public function test_update_lecture()
    {
        $this->actingAs($this->lecturer);
        $response = $this->putJson($this->lecture_url, [
            'title' => $this->title,
            'description' => $this->title,
            'link' => $this->link,
            'course_id' => $this->course->id,
            'user_id' => [$this->student->id],
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['title' => $this->title]);
    }

    public function test_student_update_lecture()
    {
        $this->actingAs($this->student);
        $response = $this->putJson($this->lecture_url, [
            'title' => $this->title,
            'description' => $this->title,
            'link' => $this->link,
            'course_id' => $this->course->id,
            'user_id' => [$this->student->id],
        ]);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_unauthorized_update_lecture()
    {
        $response = $this->putJson($this->lecture_url);

        $response
            ->assertJsonFragment(['error' => __('authorize.unauthorized')])
            ->assertStatus(400);
    }

    public function test_update_lecture_with_empty_users()
    {
        $this->actingAs($this->lecturer);
        $response = $this->putJson($this->lecture_url, [
            'title' => $this->title,
            'description' => $this->title,
            'link' => $this->link,
            'course_id' => $this->course->id,
            'user_id' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'user_id' => [
                        __('validation.required', ['attribute' => 'user id'])
                    ]
                ]
            ]);
    }

}
