<?php

namespace App\Http\Controllers\Api;

use App\Actions\Notifications\DeleteNotificationByIdAction;
use App\Actions\Notifications\DeleteNotificationByIdRequest;
use App\Actions\Notifications\DeleteNotificationsByCurrentUserIdAction;
use App\Actions\Notifications\GetNotificationsByCurrentUserIdAction;
use App\Http\Presenters\NotificationArrayPresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends ApiController
{
    public function getNotifications(
        GetNotificationsByCurrentUserIdAction $action,
        NotificationArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute();

        return $this->successResponse($presenter->presentCollection($response->getNotifications()));
    }

    public function deleteNotifications(
        DeleteNotificationsByCurrentUserIdAction $action,
    ): JsonResponse
    {
        $action->execute();

        return $this->successResponse(['message' => __('notifications.deleted')]);
    }

    public function deleteNotificationById(
        Request $request,
        DeleteNotificationByIdAction $action,
    ): JsonResponse
    {
        $action->execute(
            new DeleteNotificationByIdRequest(
                $request->get('notification_id')
            )
        );

        return $this->successResponse(['message' => __('notifications.single_deleted')]);
    }
}
