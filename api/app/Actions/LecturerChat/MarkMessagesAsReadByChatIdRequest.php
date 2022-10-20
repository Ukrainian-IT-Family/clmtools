<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

final class MarkMessagesAsReadByChatIdRequest
{
    public function __construct(
        private int $chat_id
    )
    {
    }

    public function getChatId(): int
    {
        return $this->chat_id;
    }
}
