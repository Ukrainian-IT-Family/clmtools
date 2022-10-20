<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Support\Carbon;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_id'];

    public function author(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function lectures(): HasMany {
        return $this->hasMany(Lecture::class);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function getDate(): Carbon
    {
        return $this->updated_at;
    }

    public function tasks(): HasMany {
        return $this->hasMany(Task::class);
    }
}
