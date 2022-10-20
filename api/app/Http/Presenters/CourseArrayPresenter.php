<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

final class CourseArrayPresenter
{
    public function __construct(private UserArrayPresenter $userPresenter)
    {
    }

    public function present(Course $course): array
    {
        return [
            'id' => $course->getId(),
            'title' => $course->getTitle(),
            'date' => Carbon::parse($course->getDate())->format('d.m.Y'),
            'students' => $this->userPresenter->getCollections($course->users),
        ];
    }

    public function getCollections(Collection $courses): array
    {
        return $courses->map(
                function (Course $course) {
                    return $this->present($course);
                }
            )
            ->all();
    }
}
