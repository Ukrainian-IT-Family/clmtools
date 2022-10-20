<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Http\Requests\Api\ApiFormRequest;

final class TaskEditVerificationRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3',
            'description' => 'required|min:3',
            'points' => 'integer',
            'lecture_id' => 'integer',
            'course_id' => 'required|integer',
            'user_id' => 'required|array',
        ];
    }
}
