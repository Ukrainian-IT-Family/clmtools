<?php

declare(strict_types=1);

namespace App\Actions\Lecture;

use App\Events\NotificationCreated;
use App\Helpers\Youtube;
use App\Repository\LectureRepository;
use App\Repository\NotificationRepository;

final class LectureEditAction
{
    public function __construct(
        private LectureRepository $lectureRepository,
        private NotificationRepository $notificationRepository
    )
    {
    }

    public function execute(LectureEditRequest $request): LectureResponse
    {
        $lecture = $this->lectureRepository->getById($request->getId());

        $preview_image = Youtube::getPreviewImage($request->getLink(), $request->getTitle());
        $lecture->title = $request->getTitle();
        $lecture->description = $request->getDescription();
        $lecture->link = $request->getLink();
        $lecture->preview_image = $preview_image;
        $lecture->course_id = $request->getCourseId();
        $this->lectureRepository->attach($lecture, $request->getUserId());

        $lecture = $this->lectureRepository->save($lecture);

        foreach ($request->getUserId() as $student_id) {
            $notificationFields = [
                'user_id' => $student_id,
                'title' => __('lection.lecture'),
                'description' => __('lection.added_to_the_lecture') . ' "' . $lecture->getTitle() . '"',
                'url' => '/lections/' . $lecture->getId()
            ];
            $notificationRepository = $this->notificationRepository;
            $notification = $notificationRepository->create($notificationFields);
            broadcast(
                new NotificationCreated($notification)
            )->toOthers();
        }

        return new LectureResponse(
            $lecture
        );
    }
}
