<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Http\Requests\Api\ApiFormRequest;

final class TaskSetRatingVerificationRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_ids' => 'required|array',
        ];
    }
}
