<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\TaskNotAvailableToTheCurrentUserException;
use App\Exceptions\TaskNotFoundException;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class TaskRepository
{
    public function create(array $fields): Task
    {
        return Task::create($fields);
    }

    public function getById(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function save(Task $task): Task
    {
        $task->save();

        return $task;
    }

    public function delete(int $task_id): ?bool
    {
        return Task::find($task_id)->delete();
    }

    public function getTaskByLectureId(int $lecture_id): ?Task
    {
        return Task::where('lecture_id', $lecture_id)->first();
    }

    public function getUsersByTaskId(int $task_id): Collection
    {
        return Task::find($task_id)
            ->users()
            ->get();
    }

    public function getRatingByTaskIdAndUserId(int $task_id, int $user_id): int
    {
        return Task::find($task_id)
            ->users()
            ->wherePivot('user_id', $user_id)
            ->first()
            ->pivot
            ->rating;
    }

    public function getAnswerByTaskIdAndUserId(int $task_id, int $user_id): ?string
    {
        return Task::find($task_id)
            ->users()
            ->wherePivot('user_id', $user_id)
            ->first()
            ->pivot
            ->answer;
    }

    public function getTasksByAuthor(int $id): Collection
    {
        return Task::where('author_id', $id)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function setAnswer(Task $task,int $user_id,string $answer): int
    {
        return $task->users()->updateExistingPivot($user_id, [
            'answer' => $answer
        ]);
    }

    public function setRate(Task $task,int $user_id,string $rating): int
    {
        return $task->users()->updateExistingPivot($user_id, [
            'rating' => $rating
        ]);
    }

    public function attach(Task $task, array $arr_user_id): void
    {
        $task->users()->attach(User::find($arr_user_id));
    }

    public function detach(Task $task): void
    {
        $task->users()->detach();
    }

    public function addRatingsToStudents(Task $task,array $students): void
    {
        foreach ($students as $student_id => $rating) {
            $task->users()->updateExistingPivot($student_id, [
                'rating' => $rating
            ]);
        }
    }
}
