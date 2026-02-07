<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

final class MarkNotificationAsReadRequest
{
    public function __construct(private int $notificationId)
    {
    }

    public function getNotificationId(): int
    {
        return $this->notificationId;
    }
}
