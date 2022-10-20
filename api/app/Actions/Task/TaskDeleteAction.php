<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Repository\TaskRepository;

final class TaskDeleteAction
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function execute(TaskDeleteRequest $request): void
    {
        $this->taskRepository->delete($request->getTaskId());
    }
}
