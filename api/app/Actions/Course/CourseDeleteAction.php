<?php

declare(strict_types=1);

namespace App\Actions\Course;

use App\Repository\CourseRepository;

final class CourseDeleteAction
{
    public function __construct(private CourseRepository $courseRepository)
    {
    }

    public function execute(CourseDeleteRequest $request): void
    {
        $this->courseRepository->delete($request->getCourseId());
    }
}
