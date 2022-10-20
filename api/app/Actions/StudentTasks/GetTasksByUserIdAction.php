<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

use App\Exceptions\TaskNotFoundException;
use App\Repository\UserRepository;

final class GetTasksByUserIdAction
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function execute(GetTasksByUserIdRequest $request): GetTasksByUserIdResponse
    {
        $userRepository = $this->userRepository;

        $tasks = $userRepository->getTasksByUserId($request->getUserId());

        if (!$tasks) {
            throw new TaskNotFoundException();
        }

        return new GetTasksByUserIdResponse($tasks);
    }
}
