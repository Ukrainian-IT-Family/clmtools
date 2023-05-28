<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use App\Repository\ChatRepository;

final class GetNewMessagesCountByLectureIdAndStudentIdAction
{
    public function __construct(private ChatRepository $chatRepository)
    {
    }

    public function execute($student_id, $lecture_id): int
    {
        $chatRepository = $this->chatRepository;
        $chat = $chatRepository->getChatByLectureId($student_id, $lecture_id);

        $count = $chat->messages()
            ->where('read_by_lecturer', false)
            ->get()->count();

        return $count;
    }
}
