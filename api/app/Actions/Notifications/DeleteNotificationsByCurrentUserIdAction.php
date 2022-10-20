<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Repository\NotificationRepository;
use Illuminate\Support\Facades\Auth;

final class DeleteNotificationsByCurrentUserIdAction
{
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    public function execute(): void
    {
        $notificationRepository = $this->notificationRepository;
        $notificationRepository->deleteNotificationsByUserId(Auth::id());
    }
}
