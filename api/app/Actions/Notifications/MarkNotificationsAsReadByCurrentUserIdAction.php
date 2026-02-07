<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Repository\NotificationRepository;
use Illuminate\Support\Facades\Auth;

final class MarkNotificationsAsReadByCurrentUserIdAction
{
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    public function execute(): int
    {
        return $this->notificationRepository->markAsReadByUserId(Auth::id());
    }
}
