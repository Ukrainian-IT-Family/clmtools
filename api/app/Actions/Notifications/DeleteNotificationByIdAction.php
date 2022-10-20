<?php

declare(strict_types=1);

namespace App\Actions\Notifications;

use App\Repository\NotificationRepository;

final class DeleteNotificationByIdAction
{
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    public function execute(DeleteNotificationByIdRequest $request): void
    {
        $notificationRepository = $this->notificationRepository;
        $notificationRepository->delete($request->getNotificationId());
    }
}
