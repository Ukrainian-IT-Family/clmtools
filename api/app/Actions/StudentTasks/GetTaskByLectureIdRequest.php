<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

final class GetTaskByLectureIdRequest
{
    public function __construct(private int $lecture_id)
    {
    }

    public function getLectureId(): int
    {
        return $this->lecture_id;
    }
}
