<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class ChatUserArrayPresenter
{
    public function present(User $user, int $lecture_id): array
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'last_name' => $user->getLastName(),
        ];
    }

    public function presentCollection(Collection $users, int $lecture_id): array
    {
        return $users
            ->map(
                function (User $user) use ($lecture_id) {
                    return $this->present($user, $lecture_id);
                }
            )
            ->all();
    }
}
