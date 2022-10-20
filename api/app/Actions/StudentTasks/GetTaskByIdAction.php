<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

use App\Exceptions\TaskNotAvailableToTheCurrentUserException;
use App\Exceptions\TaskNotFoundException;
use App\Repository\TaskRepository;
use Illuminate\Support\Facades\Auth;

final class GetTaskByIdAction
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function execute(GetTaskByIdRequest $request): GetTaskByIdResponse
    {
        $taskRepository = $this->taskRepository;

        $task = $taskRepository->getById($request->getId());
        if (!$task) {
            throw new TaskNotFoundException();
        }

        $users = $taskRepository->getUsersByTaskId($task['id']);
        if (!$users->contains('id', Auth::id())) {
            throw new TaskNotAvailableToTheCurrentUserException();
        }

        return new GetTaskByIdResponse($task);
    }
}
