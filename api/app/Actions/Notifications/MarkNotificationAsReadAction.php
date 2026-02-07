<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Repository\NotificationRepository;
use Illuminate\Support\Facades\Auth;

final class MarkNotificationAsReadAction
{
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    public function execute(MarkNotificationAsReadRequest $request): int
    {
        return $this->notificationRepository->markAsReadByIdAndUserId(
            $request->getNotificationId(),
            Auth::id()
        );
    }
}
