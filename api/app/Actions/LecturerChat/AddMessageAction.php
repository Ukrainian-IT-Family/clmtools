<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use App\Events\MessageCreated;
use App\Events\NotificationCreated;
use App\Models\Message;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use App\Repository\NotificationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

final class AddMessageAction
{
    public function __construct(
        private MessageRepository $messageRepository,
        private ChatRepository $chatRepository,
        private NotificationRepository $notificationRepository
    )
    {
    }

    public function execute(AddMessageRequest $request): AddMessageResponse
    {
        $chatRepository = $this->chatRepository;
        $chat = $chatRepository->getChatByLectureId($request->getStudentId(), $request->getLectureId());

        $message = new Message();
        $message->user_id = Auth::id();
        $message->chat_id = $chat->getId();
        $message->body = $request->getBody();

        if($request->getFile()){
            $filePath = Storage::putFileAs(
                'public',
                $request->getFile(),
                time() . '-' . $request->getFile()->getClientOriginalName(),
                'public'
            );
            $message->file_url = Storage::url($filePath);
        }

        $messageRepository = $this->messageRepository;
        $message = $messageRepository->save($message);

        broadcast(new MessageCreated($message))
            ->toOthers();

        $lecture = $chat->lecture()->first();

        $notificationFields = [
            'user_id' => $request->getStudentId(),
            'title' => __('chat.chat'),
            'description' => __('chat.received_a_message') . ' "' . $lecture->title . '"',
            'url' => '/lections/' . $lecture->id . '/chat'
        ];
        $notificationRepository = $this->notificationRepository;
        $notification = $notificationRepository->create($notificationFields);
        broadcast(
            new NotificationCreated($notification)
        )->toOthers();

        return new AddMessageResponse($message);
    }
}
