<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Models\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class NotificationArrayPresenter
{
    public function present(Notification $notification): array
    {
        return [
            'id' => $notification->getId(),
            'title' => $notification->getTitle(),
            'description' => $notification->getDescription(),
            'url' => $notification->getUrl(),
            'created_at' => Carbon::parse($notification->getCreatedAt())
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(
                function (Notification $notification) {
                    return $this->present($notification);
                }
            )
            ->all();
    }
}
