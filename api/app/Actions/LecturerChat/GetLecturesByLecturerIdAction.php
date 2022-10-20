<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use App\Repository\LectureRepository;
use Illuminate\Support\Facades\Auth;

final class GetLecturesByLecturerIdAction
{
    public function __construct(private LectureRepository $lectureRepository)
    {
    }

    public function execute(): GetLecturesByLecturerIdResponse
    {
        $lectureRepository = $this->lectureRepository;
        $lectures = $lectureRepository->getLecturesByLecturer(Auth::id());

        return new GetLecturesByLecturerIdResponse($lectures);
    }
}
