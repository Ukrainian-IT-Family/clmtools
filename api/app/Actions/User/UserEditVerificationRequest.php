<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Http\Requests\Api\ApiFormRequest;
use App\Enums\UserRole;
use Illuminate\Validation\Rules\Enum;

final class UserEditVerificationRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'role' => [
                "required",
                new Enum(UserRole::class)
            ]
        ];
    }
}
