<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Lecture;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UserRepository
{
    public function create(array $fields): User
    {
        return User::create($fields);
    }

    /**
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function getById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    public function getStudents(): Collection
    {
        return User::where('role', 'student')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getLecturesByUser(int $id): Collection
    {
        return User::find($id)->linkedLectures()
            ->orderBy('order', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getStudentsByCourse(int $course_id): array
    {
        return User::where(['course_id' => $course_id, 'role' => 'student'])
            ->orderBy('name', 'asc')
            ->select('id')
            ->get()
            ->toArray();
    }

    public function setStudentsCourse(array $students, ?int $course_id): ?int
    {
        return User::whereIn('id', $students)->update(['course_id' => $course_id]);
    }

    public function getStudentsByLectureId(int $id): Collection
    {
        return Lecture::find($id)->users()
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getUsers(): Collection
    {
        return User::orderBy('name', 'asc')->get();
    }

    public function delete(int $user_id): ?bool
    {
        return User::find($user_id)->delete();
    }

    public function getTasksByUserId(int $user_id): Collection
    {
        return User::find($user_id)
            ->userTasks()
            ->orderBy('id', 'desc')
            ->get();
    }
}
