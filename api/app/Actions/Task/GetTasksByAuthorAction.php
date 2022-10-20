<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Models\User;
use App\Repository\TaskRepository;
use Illuminate\Database\Eloquent\Collection;

final class GetTasksByAuthorAction
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function execute(): Collection
    {
        $lecturerId = User::getAuthUserId();

        return $this->taskRepository->getTasksByAuthor($lecturerId);
    }
}
