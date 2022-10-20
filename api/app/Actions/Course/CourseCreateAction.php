<?php

declare(strict_types=1);

namespace App\Actions\Course;

use App\Repository\{CourseRepository, UserRepository};
use App\Models\{Course, User};

final class CourseCreateAction
{
    public function __construct(private CourseRepository $courseRepository, private UserRepository $userRepository)
    {
    }

    public function execute(CourseCreateRequest $request): Course
    {
        $course = $this->courseRepository->create([
            'title' => $request->getTitle(),
            'author_id' => User::getAuthUserId(),
        ]);

        $this->userRepository->setStudentsCourse($request->getUserId(), $course->id);

        return $course;
    }
}
