<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\UserRole;

class GetUsersRolesApiTest extends TestCase
{
    use RefreshDatabase;

    private $url;
    private $role;
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
        $this->role = UserRole::NULL;
        $this->url = route('get.roles');
    }

    public function test_getting_users_roles_by_admin()
    {
        $this->actingAs($this->admin);
        $response = $this->getJson($this->url);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['null' => __('user.role.null')]);
    }

    public function test_getting_users_roles_by_lecturer()
    {
        $this->actingAs($this->lecturer);
        $response = $this->getJson($this->url);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_getting_users_roles_by_student()
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
