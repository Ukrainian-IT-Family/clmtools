<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

use Illuminate\Support\Collection;

final class GetTasksByUserIdResponse
{
    public function __construct(private Collection $tasks)
    {
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }
}
