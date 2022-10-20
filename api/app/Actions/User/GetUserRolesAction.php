<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Enums\UserRole;

final class GetUserRolesAction
{
    public function execute($roles = []): array
    {
        foreach (UserRole::values() as $role) {
            $roles[$role] = __('user.role.' . $role);
        }

        return $roles;
    }
}
