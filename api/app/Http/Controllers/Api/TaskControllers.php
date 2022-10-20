<?php

namespace App\Http\Controllers\Api;

use App\Actions\Task\GetTasksByAuthorAction;
use App\Actions\Task\GetTaskByIdAction;
use App\Actions\Task\GetTaskByIdRequest;
use App\Actions\Task\TaskCreateAction;
use App\Actions\Task\TaskCreateRequest;
use App\Actions\Task\TaskDeleteAction;
use App\Actions\Task\TaskDeleteRequest;
use App\Actions\Task\TaskEditAction;
use App\Actions\Task\TaskEditRequest;
use App\Actions\Task\TaskEditVerificationRequest;
use App\Actions\Task\TaskSetRatingAction;
use App\Actions\Task\TaskSetRatingRequest;
use App\Actions\Task\TaskSetRatingVerificationRequest;
use App\Actions\Task\TaskVerificationRequest;
use App\Http\Presenters\TaskArrayPresenter;
use Illuminate\Http\JsonResponse;

class TaskControllers extends ApiController
{
     /**
     * Getting all tasks of Lecturer as author
     */
    public function getTasks(
        GetTasksByAuthorAction $getTasksByAuthorAction,
        TaskArrayPresenter $taskArrayPresenter
    ): JsonResponse {
        $response = $getTasksByAuthorAction->execute();

        return $this->successResponse($taskArrayPresenter->getCollections($response));
    }

    /**
     * Getting task of Lecture
     */
    public function getTaskById(
        $taskId,
        GetTaskByIdAction $getTaskByIdAction,
        TaskArrayPresenter $taskArrayPresenter
    ): JsonResponse {
        $request = new GetTaskByIdRequest(
            (int)$taskId
        );
        $response = $getTaskByIdAction->execute($request);

        return $this->successResponse($taskArrayPresenter->present($response));
    }

    /**
     * Create a new Task
     */
    public function createTask(
        TaskVerificationRequest $taskVerificationRequest,
        TaskCreateAction $taskCreateAction,
        TaskArrayPresenter $taskArrayPresenter
    ): JsonResponse {
        $request = new TaskCreateRequest(
            $taskVerificationRequest->get('title'),
            $taskVerificationRequest->get('description'),
            $taskVerificationRequest->get('points'),
            $taskVerificationRequest->get('deadline'),
            $taskVerificationRequest->get('lecture_id'),
            $taskVerificationRequest->get('course_id'),
            $taskVerificationRequest->get('user_id')
        );
        $response = $taskCreateAction->execute($request);

        return $this->successResponse($taskArrayPresenter->present($response));
    }

    /**
     * Edit Task
     */
    public function editTask(
        $taskId,
        TaskEditVerificationRequest $taskEditVerificationRequest,
        TaskEditAction $taskEditAction,
        TaskArrayPresenter $taskArrayPresenter
    ): JsonResponse {
        $request = new TaskEditRequest(
            (int)$taskId,
            $taskEditVerificationRequest->get('title'),
            $taskEditVerificationRequest->get('description'),
            $taskEditVerificationRequest->get('points'),
            $taskEditVerificationRequest->get('deadline'),
            $taskEditVerificationRequest->get('lecture_id'),
            $taskEditVerificationRequest->get('course_id'),
            $taskEditVerificationRequest->get('user_id')
        );
        $response = $taskEditAction->execute($request);

        return $this->successResponse($taskArrayPresenter->present($response));
    }

    /**
     * Delete Task
     */
    public function deleteTask(
        $taskId,
        TaskDeleteAction $taskDeleteAction
    ): JsonResponse {
        $taskDeleteAction->execute(new TaskDeleteRequest(
            (int)$taskId
        ));

        return $this->successResponse(["message" => __('task.deleted')]);
    }

    /**
     * Set Task Rating for students
     */
    public function setRatingTask(
        $taskId,
        TaskSetRatingVerificationRequest $taskSetRatingVerificationRequest,
        TaskSetRatingAction $taskSetRatingAction,
        TaskArrayPresenter $taskArrayPresenter
    ): JsonResponse {
        $request = new TaskSetRatingRequest(
            (int)$taskId,
            $taskSetRatingVerificationRequest->get('user_ids')
        );
        $response = $taskSetRatingAction->execute($request);

        return $this->successResponse($taskArrayPresenter->present($response));
    }
}
