<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use App\Repository\ChatRepository;

final class MarkMessagesAsReadByChatIdAction
{
    public function __construct(private ChatRepository $chatRepository)
    {
    }

    public function execute(MarkMessagesAsReadByChatIdRequest $request): void
    {
        $chatRepository = $this->chatRepository;
        $chatRepository->markMessagesAsReadByChatId($request->getChatId());
    }
}
