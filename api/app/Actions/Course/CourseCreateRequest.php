<?php

declare(strict_types=1);

namespace App\Actions\Course;

final class CourseCreateRequest
{
    public function __construct(
        private string $title,
        private array $user_id
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUserId(): array
    {
        return $this->user_id;
    }
}
