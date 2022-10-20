<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\Collection;

final class GetUsersAction
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function execute(): Collection
    {
        return $this->userRepository->getUsers();
    }
}
