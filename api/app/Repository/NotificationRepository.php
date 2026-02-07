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
        return Notification::where('id', $id)->delete() > 0;
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

    public function markAsReadByIdAndUserId(int $notificationId, int $userId): int
    {
        return Notification::where('id', $notificationId)
            ->where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function markAsReadByUserId(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function getUnreadCountByUserId(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();
    }
}
