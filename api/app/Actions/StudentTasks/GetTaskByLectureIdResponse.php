<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

use App\Models\Task;

final class GetTaskByLectureIdResponse
{
    public function __construct(private Task $task)
    {
    }

    public function getTask(): Task
    {
        return $this->task;
    }
}
