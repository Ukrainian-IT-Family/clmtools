<?php

declare(strict_types=1);

namespace App\Actions\StudentTasks;

final class GetAnswerInfoByTaskIdResponse
{
    public function __construct(private int $rating, private int $max_rating, private ?string $answer)
    {
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getMaxRating(): int
    {
        return $this->max_rating;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }
}
