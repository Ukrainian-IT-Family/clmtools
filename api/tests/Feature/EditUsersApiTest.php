<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\UserRole;

class EditUsersApiTest extends TestCase
{
    use RefreshDatabase;

    private $url;
    private $role;
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
        $this->role = UserRole::NULL;
        $this->url = route('edit.user', ['id' => $this->student->id]);
    }

    public function test_edit_user_by_admin()
    {
        $this->actingAs($this->admin);
        $response = $this->putJson($this->url, [
            'role' => $this->role
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['role' => $this->role]);
    }

    public function test_edit_user_by_lecturer()
    {
        $this->actingAs($this->lecturer);
        $response = $this->putJson($this->url, [
            'role' => $this->role
        ]);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_edit_user_by_student()
    {
        $this->actingAs($this->student);
        $response = $this->putJson($this->url, [
            'role' => $this->role
        ]);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_unauthorized_user()
    {
        $response = $this->putJson($this->url, [
            'role' => $this->role
        ]);

        $response
            ->assertJsonFragment(['error' => __('authorize.unauthorized')])
            ->assertStatus(400);
    }

}
