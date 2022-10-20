<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Repository\UserRepository;

final class UserDeleteAction
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function execute(UserDeleteRequest $request): void
    {
        $this->userRepository->delete($request->getUserId());
    }
}
