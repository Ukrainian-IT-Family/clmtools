<?php

declare(strict_types=1);

namespace App\Actions\Lecture;

use App\Models\User;
use App\Repository\LectureRepository;

final class GetLecturesByAuthorAction
{
    public function __construct(private LectureRepository $lectureRepository)
    {
    }

    public function execute(): LectureCollectionResponse
    {
        $lectureId = User::getAuthUserId();

        return new LectureCollectionResponse(
            $this->lectureRepository->getLecturesByLecturer($lectureId)
        );
    }
}
