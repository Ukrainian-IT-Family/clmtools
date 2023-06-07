<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'points',
        'deadline',
        'author_id',
        'course_id',
        'lecture_id'
    ];

    private $studentsColumns = [
        'id',
        'name',
        'last_name',
        'profile_image',
        'pivot'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lecture(): BelongsTo
    {
        return $this->belongsTo(Lecture::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['user_id', 'answer', 'rating']);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getDeadline(): ?string
    {
        return $this->deadline;
    }

    public function getDate(): Carbon
    {
        return $this->updated_at;
    }

    public function getPassedStudents(): array
    {
        return $this->users->filter(function ($user)
        {
            return $user->pivot->answer != null;
        })->map->only($this->studentsColumns)->values()->toArray();
    }

    public function getRatedStudents(): array
    {
        return $this->users->filter(function ($user)
        {
            return $user->pivot->rating > 0;
        })->map->only($this->studentsColumns)->values()->toArray();
    }
}
