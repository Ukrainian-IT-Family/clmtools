<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

final class GetTaskByIdRequest
{
    public function __construct(private int $task_id)
    {
    }

    public function getId(): int
    {
        return $this->task_id;
    }
}
