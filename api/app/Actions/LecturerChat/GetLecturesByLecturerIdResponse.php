<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use Illuminate\Support\Collection;

final class GetLecturesByLecturerIdResponse
{
    public function __construct(private Collection $lectures)
    {
    }

    public function getLectures(): Collection
    {
        return $this->lectures;
    }
}
