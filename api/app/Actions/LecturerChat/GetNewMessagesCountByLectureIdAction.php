<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use App\Repository\ChatRepository;

final class GetNewMessagesCountByLectureIdAction
{
    public function __construct(private ChatRepository $chatRepository)
    {
    }

    public function execute($user_id): int
    {
        $chatRepository = $this->chatRepository;
        $chats = $chatRepository->getChatsByLectureId($user_id);

        $count = 0;
        foreach($chats as $chat) {
            $messages_count = $chat->messages()
                ->where('read_by_lecturer', false)
                ->get()->count();
            $count += $messages_count;
        }

        return $count;
    }
}
