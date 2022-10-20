<?php

declare(strict_types=1);

namespace App\Actions\Course;

final class CourseEditRequest
{
    public function __construct(
        private int $id,
        private string $title,
        private array $user_id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
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
