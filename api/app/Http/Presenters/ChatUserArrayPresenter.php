<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Actions\LecturerChat\GetNewMessagesCountByLectureIdAndStudentIdAction;
use App\Models\User;
use App\Repository\ChatRepository;
use Illuminate\Database\Eloquent\Collection;

final class ChatUserArrayPresenter
{
    private ChatRepository $chatRepository;

    public function __construct()
    {
        $this->chatRepository = new ChatRepository();
    }

    public function present(User $user, int $lecture_id): array
    {
        $action = new GetNewMessagesCountByLectureIdAndStudentIdAction($this->chatRepository);
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'last_name' => $user->getLastName(),
            'messages_unread_by_lecturer' => $action->execute($user->getId(), $lecture_id),
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
