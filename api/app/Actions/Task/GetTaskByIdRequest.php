<?php

declare(strict_types=1);

namespace App\Actions\Task;

final class GetTaskByIdRequest
{
    public function __construct(
        private int $taskId
    ) {
    }

    public function getId(): int
    {
        return $this->taskId;
    }
}
