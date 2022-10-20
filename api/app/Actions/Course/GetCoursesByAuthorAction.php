<?php

declare(strict_types=1);

namespace App\Actions\Course;

use App\Models\User;
use App\Repository\CourseRepository;
use Illuminate\Database\Eloquent\Collection;

final class GetCoursesByAuthorAction
{
    public function __construct(private CourseRepository $courseRepository)
    {
    }

    public function execute(): Collection
    {
        $lecturerId = User::getAuthUserId();

        return $this->courseRepository->getCoursesByAuthor($lecturerId);
    }
}
