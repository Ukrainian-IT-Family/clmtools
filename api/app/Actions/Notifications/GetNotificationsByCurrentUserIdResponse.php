<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use Illuminate\Database\Eloquent\Collection;

final class GetNotificationsByCurrentUserIdResponse
{
    public function __construct(private Collection $notifications)
    {
    }

    public function getNotifications(): Collection
    {
        return $this->notifications;
    }
}
