<?php

namespace App\Http\Controllers\Api;

use App\Actions\StudentTasks\AddAnswerAction;
use App\Actions\StudentTasks\AddAnswerRequest;
use App\Actions\StudentTasks\GetAnswerInfoByTaskIdAction;
use App\Actions\StudentTasks\GetAnswerInfoByTaskIdRequest;
use App\Actions\StudentTasks\GetTaskByIdAction;
use App\Actions\StudentTasks\GetTaskByIdRequest;
use App\Actions\StudentTasks\GetTaskByLectureIdAction;
use App\Actions\StudentTasks\GetTaskByLectureIdRequest;
use App\Actions\StudentTasks\GetTasksByUserIdAction;
use App\Actions\StudentTasks\GetTasksByUserIdRequest;
use App\Http\Presenters\TaskArrayPresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentTaskController extends ApiController
{
    public function task(
        Request $request,
        GetTaskByLectureIdAction $action,
        TaskArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute(
            new GetTaskByLectureIdRequest(
                (int)$request->get('lecture_id')
            )
        );

        return $this->successResponse($presenter->present($response->getTask()));
    }

    public function answer(
        Request $request,
        AddAnswerAction $action
    ): JsonResponse
    {
        $request = new AddAnswerRequest(
            $request->task_id,
            $request->answer
        );

        $action->execute($request);

        return $this->successResponse(['msg' => __('task.response_successfully_sent_to_teacher')], 200);
    }

    public function answerInfo(
        Request $request,
        GetAnswerInfoByTaskIdAction $action
    ): JsonResponse
    {
        $response = $action->execute(
            new GetAnswerInfoByTaskIdRequest(
                (int)$request->get('task_id')
            )
        );

        return $this->successResponse([
            'rating' => $response->getRating(),
            'max_rating' => $response->getMaxRating(),
            'answer' => $response->getAnswer()
        ], 200);
    }

    public function taskList(
        Request $request,
        GetTasksByUserIdAction $action,
        TaskArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute(
            new GetTasksByUserIdRequest(
                (int)$request->get('user_id')
            )
        );

        return $this->successResponse($presenter->getCollections($response->getTasks()));
    }

    public function taskWOLecture(
        Request $request,
        GetTaskByIdAction $action,
        TaskArrayPresenter $presenter
    ): JsonResponse
    {
        $response = $action->execute(
            new GetTaskByIdRequest(
                (int)$request->get('task_id')
            )
        );

        return $this->successResponse($presenter->present($response->getTask()));
    }
}
