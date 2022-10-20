<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

use App\Exceptions\TaskNotAvailableToTheCurrentUserException;
use App\Exceptions\TaskNotFoundException;
use App\Repository\TaskRepository;
use Illuminate\Support\Facades\Auth;

final class GetTaskByLectureIdAction
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function execute(GetTaskByLectureIdRequest $request): GetTaskByLectureIdResponse
    {
        $taskRepository = $this->taskRepository;

        $task = $taskRepository->getTaskByLectureId($request->getLectureId());
        if (!$task) {
            throw new TaskNotFoundException();
        }

        $users = $taskRepository->getUsersByTaskId($task['id']);
        if (!$users->contains('id', Auth::id())) {
            throw new TaskNotAvailableToTheCurrentUserException();
        }

        return new GetTaskByLectureIdResponse($task);
    }
}
