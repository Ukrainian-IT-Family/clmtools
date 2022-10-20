<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Actions\LecturerChat\GetNewMessagesCountByLectureIdAction;
use App\Models\Lecture;
use App\Repository\ChatRepository;
use Illuminate\Support\Collection;

final class ChatLectureArrayPresenter
{
    private ChatRepository $chatRepository;

    public function __construct()
    {
        $this->chatRepository = new ChatRepository();
    }

    public function present(Lecture $lecture): array
    {
        $action = new GetNewMessagesCountByLectureIdAction($this->chatRepository);
        return [
            'id' => $lecture->getId(),
            'title' => $lecture->getTitle(),
            'messages_unread_by_lecturer' => $action->execute($lecture->getId())
        ];
    }

    public function presentCollection(Collection $lectures): array
    {
        return $lectures
            ->map(
                function (Lecture $lecture) {
                    return $this->present($lecture);
                }
            )
            ->all();
    }
}
