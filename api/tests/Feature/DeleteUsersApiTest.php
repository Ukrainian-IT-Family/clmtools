<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\UserRole;

class DeleteUsersApiTest extends TestCase
{
    use RefreshDatabase;

    private $url;
    private $admin;
    private $student;
    private $lecturer;

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
        $this->url = route('delete.user', ['id' => $this->student->id]);
    }

    public function tearDown(): void
    {
        $this->refreshApplication();
    }

    public function test_delete_user_by_admin()
    {
        $this->actingAs($this->admin);
        $response = $this->deleteJson($this->url);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['message' => __('user.deleted')]);
    }

    public function test_delete_user_by_lecturer()
    {
        $this->actingAs($this->lecturer);
        $response = $this->deleteJson($this->url);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_delete_user_by_student()
    {
        $this->actingAs($this->student);
        $response = $this->deleteJson($this->url);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_unauthorized_user()
    {
        $response = $this->deleteJson($this->url);

        $response
            ->assertJsonFragment(['error' => __('authorize.unauthorized')])
            ->assertStatus(400);
    }

}
