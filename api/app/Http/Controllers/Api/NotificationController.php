<?php

namespace App\Http\Controllers\Api;

use App\Actions\Notifications\DeleteNotificationByIdAction;
use App\Actions\Notifications\DeleteNotificationByIdRequest;
use App\Actions\Notifications\DeleteNotificationsByCurrentUserIdAction;
use App\Actions\Notifications\GetNotificationsByCurrentUserIdAction;
use App\Actions\Notifications\GetUnreadNotificationsCountByCurrentUserIdAction;
use App\Actions\Notifications\MarkNotificationAsReadAction;
use App\Actions\Notifications\MarkNotificationAsReadRequest;
use App\Actions\Notifications\MarkNotificationsAsReadByCurrentUserIdAction;
use App\Http\Presenters\NotificationArrayPresenter;
use App\Http\Requests\Api\Notifications\MarkNotificationAsReadValidationRequest;
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

    public function markNotificationAsRead(
        MarkNotificationAsReadValidationRequest $request,
        MarkNotificationAsReadAction $action
    ): JsonResponse
    {
        $affected = $action->execute(
            new MarkNotificationAsReadRequest(
                (int)$request->get('notification_id')
            )
        );

        return $this->successResponse([
            'message' => __('notifications.single_read'),
            'affected' => $affected
        ]);
    }

    public function markNotificationsAsRead(
        MarkNotificationsAsReadByCurrentUserIdAction $action
    ): JsonResponse
    {
        $affected = $action->execute();

        return $this->successResponse([
            'message' => __('notifications.read_all'),
            'affected' => $affected
        ]);
    }

    public function getUnreadNotificationsCount(
        GetUnreadNotificationsCountByCurrentUserIdAction $action
    ): JsonResponse
    {
        return $this->successResponse([
            'count' => $action->execute()
        ]);
    }
}
