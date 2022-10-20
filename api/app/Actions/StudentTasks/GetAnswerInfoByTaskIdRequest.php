<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

final class GetAnswerInfoByTaskIdRequest
{
    public function __construct(private int $task_id)
    {
    }

    public function getTaskId(): int
    {
        return $this->task_id;
    }
}
