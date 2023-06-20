<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UploadProfileImageApiTest extends TestCase
{
    private string $api_url;
    private mixed $file;
    private mixed $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->api_url = 'api/v1/auth/me/image';
        $this->email = 'test3@example.com';
        $this->file = UploadedFile::fake()->create('my_avatar',3072,'image/jpeg');
        $this->user = User::factory()->create([
            'name' => 'Test',
            'last_name' => 'User',
            'email' => $this->email,
            'phone' => '380951122333',
            'password' => Hash::make('RandomPassword123'),
            'email_verified_at' => Carbon::now(),
        ]);
    }

    public function TearDown(): void
    {
        $this->api_url = '';
        $this->file = null;
        User::destroy($this->user->id);
    }

    public function test_image_upload_success()
    {
        $this->actingAs($this->user);
        $response = $this->postJson($this->api_url, [
            'image' => $this->file
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $this->user->id,
                'avatar' => env('APP_URL') . $this->user->profile_image,
                'email' => $this->user->email,
                'name' => $this->user->name,
                'last_name' => $this->user->last_name,
                'date_birth' => $this->user->date_birth,
                'phone' => $this->user->phone,
                'email_verified_at' => $this->user->email_verified_at,
                'city' => $this->user->city,
                'university' => $this->user->university,
                'graduation_year' => (int)$this->user->graduation_year,
                'role' => $this->user->role,
        ]);
    }

    public function test_image_size()
    {
        $this->actingAs($this->user);
        $this->file = UploadedFile::fake()->create('my_avatar',6000,'image/jpeg');
        $response = $this->postJson($this->api_url, [
            'image' => $this->file
        ]);

        $response
            ->assertStatus(422)
            ->assertJson(([
                "message" => __('validation.max.file',['attribute' => 'image','max' => '5120']),
                "errors" => [
                    "image" => [__('validation.max.file',['attribute' => 'image','max' => '5120'])],
                ]
            ]));
    }

    public function test_file_for_image()
    {
        $this->actingAs($this->user);
        $this->file = UploadedFile::fake()->create('my_avatar',3000,'application/pdf');
        $response = $this->postJson($this->api_url, [
            'file' => $this->file
        ]);

        $response
            ->assertStatus(422)
            ->assertJson(([
                "message" => __('validation.required',['attribute' => 'image']),
                "errors" => [
                    "image" => [__('validation.required',['attribute' => 'image'])],
                ]
            ]));
    }

    public function test_image_required()
    {
        $this->actingAs($this->user);
        $this->file = '';
        $response = $this->postJson($this->api_url, [
            'file' => $this->file
        ]);

        $response
            ->assertStatus(422)
            ->assertJson(([
                "message" => __('validation.required',['attribute' => 'image']),
                "errors" => [
                    "image" => [__('validation.required',['attribute' => 'image'])],
                ]
            ]));
    }

}
