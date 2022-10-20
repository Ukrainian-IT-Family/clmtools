<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

use App\Events\NotificationCreated;
use App\Exceptions\TaskNotAvailableToTheCurrentUserException;
use App\Exceptions\TaskNotFoundException;
use App\Repository\NotificationRepository;
use App\Repository\TaskRepository;
use Illuminate\Support\Facades\Auth;

final class AddAnswerAction
{
    public function __construct(
        private TaskRepository $taskRepository,
        private NotificationRepository $notificationRepository
    )
    {
    }

    public function execute(AddAnswerRequest $request): void
    {
        $taskRepository = $this->taskRepository;

        $task = $taskRepository->getById($request->getTaskId());
        if (!$task) {
            throw new TaskNotFoundException();
        }

        $users = $taskRepository->getUsersByTaskId($task['id']);
        if (!$users->contains('id', Auth::id())) {
            throw new TaskNotAvailableToTheCurrentUserException();
        }

        $taskRepository->setAnswer($task, Auth::id(), $request->getAnswer());

        $notificationFields = [
            'user_id' => $task->author_id,
            'title' => __('task.task'),
            'description' => Auth::user()->last_name . ' ' . Auth::user()->name . ' ' . __('task.sent_a_reply'),
            'url' => '/tasks/' . $task->id
        ];
        $notificationRepository = $this->notificationRepository;
        $notification = $notificationRepository->create($notificationFields);
        broadcast(
            new NotificationCreated($notification)
        )->toOthers();
    }
}
