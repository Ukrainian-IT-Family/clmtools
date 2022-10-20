<?php

declare(strict_types=1);

namespace App\Actions\User;

final class UserEditRequest
{
    public function __construct(
        private int $id,
        private string $role
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
