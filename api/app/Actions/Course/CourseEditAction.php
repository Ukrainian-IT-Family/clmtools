<?php

declare(strict_types=1);

namespace App\Actions\Course;

use App\Models\Course;
use App\Repository\{CourseRepository, UserRepository};

final class CourseEditAction
{
    public function __construct(private CourseRepository $courseRepository, private UserRepository $userRepository)
    {
    }

    public function execute(CourseEditRequest $request): Course
    {
        $course = $this->courseRepository->getById($request->getId());
        $course->title = $request->getTitle();
        $this->courseRepository->clearStudents($course);
        if ($request->getUserId()) {
            $this->userRepository->setStudentsCourse($request->getUserId(), $request->getId());
        }
        $course = $this->courseRepository->save($course);

        return $course;
    }
}
