<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    private $email;
    private $password;
    private $api_url;
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->email = 'test@example.com';
        $this->password = 'Ye4oKoEa3Ro9llC';
        $this->api_url = route('login');
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => Str::random(5).'@'.Str::random(5).'.com',
            'password' => Hash::make($this->password),
        ]);
    }

    public function test_existing_user()
    {
        $response = $this->postJson($this->api_url, [
            'email' => $this->user->email,
            'password' => $this->password
        ]);

        $response
            ->assertStatus(200)
            ->assertSeeText('access_token');
    }

    public function test_nonexistent_user()
    {
        $response = $this->postJson($this->api_url, [
            'email' => Str::random(15).'@mail.com',
            'password' => $this->password
        ]);

        $response
            ->assertJsonFragment(['message' => __('authorize.incorrect_login_or_password')])
            ->assertStatus(400);
    }

    public function test_incorrect_email()
    {
        $response = $this->postJson($this->api_url, [
            'email' => Str::random(10),
            'password' => $this->password
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonFragment(['email' => ["The e-mail must be a valid email address."]]);
    }

    public function test_incorrect_password()
    {
        $response = $this->postJson($this->api_url, [
            'email' => $this->email,
            'password' => 'asd',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                'password' => [
                    "The password must be at least 8 characters.",
                    "The password must contain at least one number.",
                    "The password must contain at least one uppercase and one lowercase letter."
                ]
            ]);
    }
}
