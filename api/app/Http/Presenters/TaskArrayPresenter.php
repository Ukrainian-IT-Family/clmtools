<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

final class TaskArrayPresenter
{
    public function __construct(private UserArrayPresenter $userPresenter)
    {
    }

    public function present(Task $task): array
    {
        return [
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'points' => $task->getPoints(),
            'deadline' => Carbon::parse($task->getDeadline())->format('d.m.Y H:i'),
            'date' => Carbon::parse($task->getDate())->format('d.m.Y'),
            'course' => [
                'id' => $task->course->id,
                'title' => $task->course->title,
            ],
            'lecture' => [
                'id' => $task->lecture ? $task->lecture->id : '',
                'title' => $task->lecture ? $task->lecture->title : '',
            ],
            'students' => $this->userPresenter->getCollections($task->users),
            'passed' => $task->getPassedStudents(),
            'rated' => $task->getRatedStudents()
        ];
    }

    public function getCollections(Collection $tasks): array
    {
        return $tasks->map(

            function (Task $task) {
                return $this->present($task);
            }
        )
            ->all();
    }
}
