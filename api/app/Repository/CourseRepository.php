<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class CourseRepository
{
    public function create(array $fields): Course
    {
        return Course::create($fields);
    }

    public function getById(int $id): Course
    {
        return Course::findOrFail($id);
    }

    public function save(Course $course): Course
    {
        $course->save();

        return $course;
    }

    public function getCoursesByAuthor(int $id): Collection
    {
        return Course::where('author_id', $id)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function delete(int $course_id): ?bool
    {
        return Course::find($course_id)->delete();
    }

    public function getUsersId(int $course_id): ?array
    {
        return Course::find($course_id)->users->map(
            function (User $user) {
                return $user->id;
            }
        )->toArray();
    }

    public function clearStudents(Course $course): int
    {
        return $course->users()->update(['course_id' => null]);
    }
}
