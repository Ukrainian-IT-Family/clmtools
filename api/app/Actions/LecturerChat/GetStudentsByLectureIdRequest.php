<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

final class GetStudentsByLectureIdRequest
{
    public function __construct(
        private int $lecture_id
    )
    {
    }

    public function getLectureId(): int
    {
        return $this->lecture_id;
    }
}
