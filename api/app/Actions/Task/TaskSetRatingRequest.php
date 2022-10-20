<?php

declare(strict_types=1);

namespace App\Actions\Task;

final class TaskSetRatingRequest
{
    public function __construct(
        private int $taskId,
        private array $user_ids
    ) {
    }

    public function getId(): int
    {
        return $this->taskId;
    }

    public function getStudentsId(): array
    {
        return $this->user_ids;
    }
}
