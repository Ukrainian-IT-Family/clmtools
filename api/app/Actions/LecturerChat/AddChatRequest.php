<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

final class AddChatRequest
{
    public function __construct(private int $user_id, private int $lecture_id)
    {
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getLectureId(): int
    {
        return $this->lecture_id;
    }
}
