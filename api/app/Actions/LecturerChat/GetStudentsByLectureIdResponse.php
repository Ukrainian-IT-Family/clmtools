<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use Illuminate\Support\Collection;

final class GetStudentsByLectureIdResponse
{
    public function __construct(private Collection $users)
    {
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }
}
