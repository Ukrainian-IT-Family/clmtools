<?php

declare(strict_types=1);

namespace App\Actions\Course;

use App\Http\Requests\Api\ApiFormRequest;

final class CourseVerificationRequest extends ApiFormRequest
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
            'user_id' => 'required|array',
        ];
    }
}
