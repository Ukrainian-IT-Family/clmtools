<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Events\NotificationCreated;
use App\Repository\NotificationRepository;
use App\Repository\TaskRepository;
use App\Models\{Task,User};

final class TaskCreateAction
{
    public function __construct(
        private TaskRepository $taskRepository,
        private NotificationRepository $notificationRepository
    )
    {
    }

    public function execute(TaskCreateRequest $request): Task
    {
        $task = $this->taskRepository->create([
            'title' => $request->getTitle(),
            'description' => $request->getDescription(),
            'points' => $request->getPoints(),
            'deadline' => $request->getDeadline(),
            'author_id' => User::getAuthUserId(),
            'course_id' => $request->getCourseId(),
            'lecture_id' => $request->getLectionId() > 0 ? $request->getLectionId() : null
        ]);

        $this->taskRepository->detach($task);
        $this->taskRepository->attach($task, $request->getStudentsId());

        foreach ($request->getStudentsId() as $student_id) {
            $notificationFields = [
                'user_id' => $student_id,
                'title' => __('task.task'),
                'description' => __('task.given_a_task') . ' "' . $task->getTitle() . '"',
                'url' => $task->lecture_id === null ? '/student-task/' . $task->getId() : '/lections/' . $task->getId() . '/task'
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
