<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class NotificationsApiTest extends TestCase
{
    use RefreshDatabase;

    private string $unreadCountUrl;
    private string $readAllUrl;
    private string $readOneUrl;
    private User $user;
    private User $otherUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => UserRole::STUDENT
        ]);
        $this->otherUser = User::factory()->create([
            'role' => UserRole::LECTURER
        ]);

        $this->unreadCountUrl = route('notifications.unread-count');
        $this->readAllUrl = route('notifications.read-all');
        $this->readOneUrl = route('notification.read');
    }

    public function test_get_unread_notifications_count_for_current_user()
    {
        Notification::create([
            'user_id' => $this->user->id,
            'title' => 'Test 1',
            'description' => 'Unread 1',
            'url' => '/test-1',
            'read_at' => null,
        ]);
        Notification::create([
            'user_id' => $this->user->id,
            'title' => 'Test 2',
            'description' => 'Unread 2',
            'url' => '/test-2',
            'read_at' => null,
        ]);
        Notification::create([
            'user_id' => $this->user->id,
            'title' => 'Test 3',
            'description' => 'Read',
            'url' => '/test-3',
            'read_at' => Carbon::now(),
        ]);
        Notification::create([
            'user_id' => $this->otherUser->id,
            'title' => 'Other user',
            'description' => 'Unread',
            'url' => '/test-4',
            'read_at' => null,
        ]);

        $this->actingAs($this->user);
        $response = $this->getJson($this->unreadCountUrl);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['count' => 2]);
    }

    public function test_mark_single_notification_as_read()
    {
        $notification = Notification::create([
            'user_id' => $this->user->id,
            'title' => 'To read',
            'description' => 'Unread notification',
            'url' => '/read-one',
            'read_at' => null,
        ]);

        $this->actingAs($this->user);
        $response = $this->postJson($this->readOneUrl, [
            'notification_id' => $notification->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['message' => __('notifications.single_read')]);

        $notification->refresh();
        $this->assertNotNull($notification->read_at);
    }

    public function test_mark_all_notifications_as_read_for_current_user_only()
    {
        Notification::create([
            'user_id' => $this->user->id,
            'title' => 'User unread 1',
            'description' => 'Unread',
            'url' => '/user-unread-1',
            'read_at' => null,
        ]);
        Notification::create([
            'user_id' => $this->user->id,
            'title' => 'User unread 2',
            'description' => 'Unread',
            'url' => '/user-unread-2',
            'read_at' => null,
        ]);
        Notification::create([
            'user_id' => $this->otherUser->id,
            'title' => 'Other unread',
            'description' => 'Unread',
            'url' => '/other-unread',
            'read_at' => null,
        ]);

        $this->actingAs($this->user);
        $response = $this->postJson($this->readAllUrl);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['message' => __('notifications.read_all')]);

        $this->assertEquals(
            0,
            Notification::where('user_id', $this->user->id)->whereNull('read_at')->count()
        );
        $this->assertEquals(
            1,
            Notification::where('user_id', $this->otherUser->id)->whereNull('read_at')->count()
        );
    }

    public function test_mark_single_notification_as_read_validates_input()
    {
        $this->actingAs($this->user);
        $response = $this->postJson($this->readOneUrl, []);

        $response->assertStatus(422);
    }

    public function test_unauthorized_user_cannot_get_unread_count()
    {
        $response = $this->getJson($this->unreadCountUrl);

        $response
            ->assertJsonFragment(['error' => __('authorize.unauthorized')])
            ->assertStatus(400);
    }
}
