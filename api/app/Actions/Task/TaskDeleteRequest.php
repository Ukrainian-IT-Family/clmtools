<?php

declare(strict_types=1);

namespace App\Actions\Task;

final class TaskDeleteRequest
{
    public function __construct(
        private int $taskId
    ) {
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }
}
