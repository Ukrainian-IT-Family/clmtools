<?php

declare(strict_types=1);

namespace App\Actions\Lecture;

use App\Events\NotificationCreated;
use App\Repository\LectureRepository;
use App\Models\User;
use App\Repository\NotificationRepository;

final class LectureCreateAction
{
    public function __construct(
        private LectureRepository $lectureRepository,
        private NotificationRepository $notificationRepository
    )
    {
    }

    public function execute(LectureCreateRequest $request): LectureResponse
    {
        $link_parts = '';
        parse_str(parse_url($request->getLink(), PHP_URL_QUERY), $query);
        if (isset($query['v'])) {
            $link_parts = $query['v'];
        }

        $preview_image = $link_parts ?
            config('constants.thumbnail.youtube') . $link_parts . config('constants.thumbnail.youtube_size') :
            config('constants.thumbnail.empty') . $request->getTitle();

        $lecture = $this->lectureRepository->create([
            'title' => $request->getTitle(),
            'description' => $request->getDescription(),
            'link' => $request->getLink(),
            'preview_image' => $preview_image,
            'course_id' => $request->getCourseId(),
            'author_id' => User::getAuthUserId(),
        ], $request->getUserId());

        $this->lectureRepository->attach($lecture, $request->getUserId());

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
