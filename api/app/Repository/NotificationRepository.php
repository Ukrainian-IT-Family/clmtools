<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Notification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;

final class NotificationRepository
{
    public function create(array $fields): Notification
    {
        return Notification::create($fields);
    }

    /**
     * @param int $id
     * @return Notification
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Notification
    {
        return Notification::findOrFail($id);
    }

    public function save(Notification $notification): Notification
    {
        $notification->save();

        return $notification;
    }

    public function delete(int $id): ?bool
    {
        return Notification::find($id)->delete();
    }

    public function getNotificationsByUserId(int $user_id): Collection
    {
        return Notification::where([
            ['user_id', $user_id],
        ])->orderBy('created_at', 'desc')
            ->get();
    }

    public function deleteNotificationsByUserId(int $user_id): int
    {
        return Notification::where([
            ['user_id', $user_id],
        ])->delete();
    }
}
