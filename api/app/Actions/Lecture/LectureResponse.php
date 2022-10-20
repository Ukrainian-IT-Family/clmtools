<?php

declare(strict_types=1);

namespace App\Actions\Lecture;

use Illuminate\Support\Carbon;
use App\Repository\LectureRepository;

final class LectureResponse
{
    public function __construct(
        private object $lecture
    ) {
    }

    public function getLectureTitle(): ?string
    {
        return $this->lecture->title;
    }

    public function getLectureImage(): ?string
    {
        return $this->lecture->preview_image;
    }

    public function getLectureLink(): ?string
    {
        return $this->lecture->link;
    }

    public function getLectureDate(): Carbon
    {
        return $this->lecture->updated_at ? $this->lecture->updated_at : $this->lecture->created_at;
    }

    public function getLectureId(): int
    {
        return $this->lecture->id;
    }

    public function getLectureCourse(): string
    {
        return $this->lecture->course->title;
    }

    public function getTaskId(): ?int
    {
        return $this->lecture->task?->id;
    }

    public function getLectureDescription(): ?string
    {
        return $this->lecture->description;
    }

    public function getLectureCourseId(): int
    {
        return $this->lecture->course->id;
    }

    public function getStudentsId(): array
    {
        $lectureRepository = new LectureRepository;
        return $lectureRepository->getUsersId($this->getLectureId());
    }
}
