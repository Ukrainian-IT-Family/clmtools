<?php

declare(strict_types=1);

namespace App\Actions\Course;

final class CourseDeleteRequest
{
    public function __construct(
        private int $course_id
    ) {
    }

    public function getCourseId(): int
    {
        return $this->course_id;
    }
}
