<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Notifications;

use App\Http\Requests\Api\ApiFormRequest;

final class MarkNotificationAsReadValidationRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'notification_id' => 'required|integer|min:1',
        ];
    }
}
