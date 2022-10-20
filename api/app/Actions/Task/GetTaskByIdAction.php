<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Models\Task;
use App\Repository\TaskRepository;

final class GetTaskByIdAction
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function execute(GetTaskByIdRequest $request): Task
    {
        return $this->taskRepository->getById($request->getId());
    }
}
