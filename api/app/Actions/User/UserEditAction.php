<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use App\Repository\UserRepository;

final class UserEditAction
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function execute(UserEditRequest $request): User
    {
        $user = $this->userRepository->getById($request->getId());
        $user->role = $request->getRole();
        $user = $this->userRepository->save($user);

        return $user;
    }
}
