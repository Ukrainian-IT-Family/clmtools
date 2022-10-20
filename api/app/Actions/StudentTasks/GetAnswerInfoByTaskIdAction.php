<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

use App\Exceptions\TaskNotFoundException;
use App\Repository\TaskRepository;
use Illuminate\Support\Facades\Auth;

final class GetAnswerInfoByTaskIdAction
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function execute(GetAnswerInfoByTaskIdRequest $request): GetAnswerInfoByTaskIdResponse
    {
        $taskRepository = $this->taskRepository;

        $task = $taskRepository->getById($request->getTaskId());
        if (!$task) {
            throw new TaskNotFoundException();
        }

        $rating = $taskRepository->getRatingByTaskIdAndUserId($task['id'], Auth::id());
        $maxRating = $taskRepository->getById($task['id'])->getPoints();
        $answer = $taskRepository->getAnswerByTaskIdAndUserId($task['id'], Auth::id());

        return new GetAnswerInfoByTaskIdResponse($rating, $maxRating, $answer);
    }
}
