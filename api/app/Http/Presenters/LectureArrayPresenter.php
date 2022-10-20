<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Actions\Lecture\LectureCollectionResponse;
use App\Actions\Lecture\LectureResponse;
use App\Models\Lecture;
use Illuminate\Support\Carbon;

final class LectureArrayPresenter
{
    public function present(LectureResponse $lecture): array
    {
        return [
            'id' => $lecture->getLectureId(),
            'title' => $lecture->getLectureTitle(),
            'description' => $lecture->getLectureDescription(),
            'image' => $lecture->getLectureImage(),
            'link' => $lecture->getLectureLink(),
            'created_at' => Carbon::parse($lecture->getLectureDate())->format('d.m.Y'),
            'course' => $lecture->getLectureCourse(),
            'course_id' => $lecture->getLectureCourseId(),
            'students' => $lecture->getStudentsId(),
            'task_id' => $lecture->getTaskId(),
        ];
    }

    public function getCollections(LectureCollectionResponse $lectures): array
    {
        return $lectures->getLecture()
            ->map(
                function (Lecture $lecture) {
                    return $this->present(new LectureResponse($lecture));
                }
            )
            ->all();
    }
}
