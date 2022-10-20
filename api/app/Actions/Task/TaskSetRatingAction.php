<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Events\NotificationCreated;
use App\Models\Task;
use App\Repository\NotificationRepository;
use App\Repository\TaskRepository;

final class TaskSetRatingAction
{
    public function __construct(
        private TaskRepository $taskRepository,
        private NotificationRepository $notificationRepository
    )
    {
    }

    public function execute(TaskSetRatingRequest $request): Task
    {
        $task = $this->taskRepository->getById($request->getId());
        $this->taskRepository->addRatingsToStudents($task, $request->getStudentsId());

        foreach ($request->getStudentsId() as $student_id => $rating) {
            $notificationFields = [
                'user_id' => $student_id,
                'title' => __('task.task'),
                'description' => __('task.homework_graded'),
                'url' => $task->lecture_id === null ? '/student-task/' . $task->id : '/lections/' . $task->lecture_id . '/task'
            ];
            $notificationRepository = $this->notificationRepository;
            $notification = $notificationRepository->create($notificationFields);
            broadcast(
                new NotificationCreated($notification)
            )->toOthers();
        }

        return $task;
    }
}
