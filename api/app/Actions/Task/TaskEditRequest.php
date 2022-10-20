<?php

declare(strict_types=1);

namespace App\Actions\Task;

final class TaskEditRequest
{
    public function __construct(
        private int $taskId,
        private string $title,
        private string $description,
        private ?int $points,
        private ?string $deadline,
        private ?int $lecture_id,
        private int $course_id,
        private array $user_id
    ) {
    }

    public function getId(): int
    {
        return $this->taskId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function getDeadline(): ?string
    {
        return $this->deadline;
    }

    public function getLectionId(): ?int
    {
        return $this->lecture_id;
    }

    public function getCourseId(): int
    {
        return $this->course_id;
    }

    public function getStudentsId(): array
    {
        return $this->user_id;
    }
}
