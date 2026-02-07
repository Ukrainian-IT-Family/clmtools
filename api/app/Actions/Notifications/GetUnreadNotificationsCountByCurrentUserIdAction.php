<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Repository\NotificationRepository;
use Illuminate\Support\Facades\Auth;

final class GetUnreadNotificationsCountByCurrentUserIdAction
{
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    public function execute(): int
    {
        return $this->notificationRepository->getUnreadCountByUserId(Auth::id());
    }
}
