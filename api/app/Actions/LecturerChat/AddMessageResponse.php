<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use App\Models\Message;

final class AddMessageResponse
{
    public function __construct(private Message $message)
    {
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}
