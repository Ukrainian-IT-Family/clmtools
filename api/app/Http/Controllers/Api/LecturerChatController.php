<?php

namespace App\Http\Controllers\Api;

use App\Actions\LecturerChat\AddChatAction;
use App\Actions\LecturerChat\AddChatRequest;
use App\Actions\LecturerChat\AddMessageAction;
use App\Actions\LecturerChat\AddMessageRequest;
use App\Actions\LecturerChat\GetLecturesByLecturerIdAction;
use App\Actions\LecturerChat\GetStudentsByLectureIdAction;
use App\Actions\LecturerChat\GetStudentsByLectureIdRequest;
use App\Actions\LecturerChat\MarkMessagesAsReadByChatIdAction;
use App\Actions\LecturerChat\MarkMessagesAsReadByChatIdRequest;
use App\Http\Presenters\ChatArrayPresenter;
use App\Http\Presenters\ChatLectureArrayPresenter;
use App\Http\Presenters\ChatUserArrayPresenter;
use App\Http\Presenters\MessageArrayPresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LecturerChatController extends ApiController
{
    public function getLecturesByLecturerId(
        GetLecturesByLecturerIdAction $action,
        ChatLectureArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute();

        return $this->successResponse($presenter->presentCollection($response->getLectures()));
    }

    public function store(
        Request $request,
        AddChatAction $action,
        ChatArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute(
            new AddChatRequest(
                $request->get('user_id'),
                $request->get('lecture_id')
            )
        );

        return $this->successResponse($presenter->present($response->getChat()));
    }

    public function storeMessage(
        Request $request,
        AddMessageAction $action,
        MessageArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute(
            new AddMessageRequest(
                $request->get('lecture_id'),
                $request->get('body'),
                $request->get('student_id'),
                $request->file('file')
            )
        );

        return $this->successResponse($presenter->present($response->getMessage()));
    }

    public function getStudentsByLectureId(
        Request $request,
        GetStudentsByLectureIdAction $action,
        ChatUserArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute(
            new GetStudentsByLectureIdRequest(
                $request->get('lecture_id')
            )
        );

        return $this->successResponse($presenter->presentCollection($response->getUsers(), $request->get('lecture_id')));
    }

    public function markMessagesAsReadByChatId(
        Request $request,
        MarkMessagesAsReadByChatIdAction $action
    ): JsonResponse
    {
        $action->execute(
            new MarkMessagesAsReadByChatIdRequest(
                $request->get('chat_id')
            )
        );

        return $this->successResponse(['msg' => __('chat.messages_are_marked_as_read')], 200);
    }
}
