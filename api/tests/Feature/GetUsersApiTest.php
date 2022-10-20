<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\UserRole;

class GetUsersApiTest extends TestCase
{
    use RefreshDatabase;

    private $url;
    private $id;
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
        $this->id = $this->student->id;
        $this->url = route('get.users');
    }

    public function tearDown(): void
    {
        $this->refreshApplication();
    }

    public function test_getting_users_by_admin()
    {
        $this->actingAs($this->admin);
        $response = $this->getJson($this->url);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $this->id]);
    }

    public function test_getting_users_by_lecturer()
    {
        $this->actingAs($this->lecturer);
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
