<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

final class DeleteNotificationByIdRequest
{
    public function __construct(private int $notification_id)
    {
    }

    public function getNotificationId(): int
    {
        return $this->notification_id;
    }
}
