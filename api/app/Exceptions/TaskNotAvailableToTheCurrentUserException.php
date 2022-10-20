<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;

final class TaskNotAvailableToTheCurrentUserException extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(__('task.task_not_available_to_the_current_user'), 401, $previous);
    }
}
