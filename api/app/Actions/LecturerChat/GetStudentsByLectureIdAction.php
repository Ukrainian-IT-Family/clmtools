<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use App\Repository\UserRepository;

final class GetStudentsByLectureIdAction
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function execute(GetStudentsByLectureIdRequest $request): GetStudentsByLectureIdResponse
    {
        $userRepository = $this->userRepository;
        $students = $userRepository->getStudentsByLectureId($request->getLectureId());

        return new GetStudentsByLectureIdResponse($students);
    }
}
