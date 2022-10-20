<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use App\Events\ChatCreated;
use App\Models\Chat;
use App\Repository\ChatRepository;

final class AddChatAction
{
    public function __construct(private ChatRepository $chatRepository)
    {
    }

    public function execute(AddChatRequest $request): AddChatResponse
    {
        $chat = new Chat();
        $chat->user_id = $request->getUserId();
        $chat->lecture_id = $request->getLectureId();

        $chatRepository = $this->chatRepository;
        $chat = $chatRepository->save($chat);

        broadcast(new ChatCreated($chat))
            ->toOthers();

        return new AddChatResponse($chat);
    }
}
