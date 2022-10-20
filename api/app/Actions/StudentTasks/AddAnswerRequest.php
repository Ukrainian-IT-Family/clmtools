<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

final class AddAnswerRequest
{
    public function __construct(private int $task_id, private string $answer)
    {
    }

    public function getTaskId(): int
    {
        return $this->task_id;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }
}
