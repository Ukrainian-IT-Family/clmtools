<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\ChatNotFoundException;
use App\Models\Chat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ChatRepository
{
    public function create(array $fields): Chat
    {
        return Chat::create($fields);
    }

    /**
     * @param int $id
     * @return Chat
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Chat
    {
        return Chat::findOrFail($id);
    }

    public function save(Chat $chat): Chat
    {
        $chat->save();

        return $chat;
    }

    public function getChatByLectureId(int $user_id, int $lecture_id): Chat
    {
        $chat = Chat::where([
            ['user_id', $user_id],
            ['lecture_id', $lecture_id]
        ])->first();

        if (!$chat) {
            throw new ChatNotFoundException();
        }

        return $chat;
    }

    public function getChatsByLectureId(int $lecture_id): Collection
    {
        return Chat::where('lecture_id', $lecture_id)->get();
    }

    public function markMessagesAsReadByChatId(int $chat_id): void
    {
        Chat::findOrFail($chat_id)
            ->first()
            ->messages()
            ->where('read_by_lecturer', false)
            ->update(['read_by_lecturer' => true]);
    }
}
