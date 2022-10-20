<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Repository\NotificationRepository;
use Illuminate\Support\Facades\Auth;

final class GetNotificationsByCurrentUserIdAction
{
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    public function execute(): GetNotificationsByCurrentUserIdResponse
    {
        $notificationRepository = $this->notificationRepository;
        $notifications = $notificationRepository->getNotificationsByUserId(Auth::id());

        return new GetNotificationsByCurrentUserIdResponse($notifications);
    }
}
