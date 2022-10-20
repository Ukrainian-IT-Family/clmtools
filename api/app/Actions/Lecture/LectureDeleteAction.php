<?php

declare(strict_types=1);

namespace App\Actions\Lecture;

use App\Repository\LectureRepository;

final class LectureDeleteAction
{
    public function __construct(private LectureRepository $lectureRepository)
    {
    }

    public function execute(LectureDeleteRequest $request): void
    {
        $this->lectureRepository->delete($request->getLectureId());
    }
}
