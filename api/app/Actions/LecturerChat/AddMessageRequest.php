<?php

declare(strict_types=1);

namespace App\Actions\LecturerChat;

use Illuminate\Http\UploadedFile;

final class AddMessageRequest
{
    public function __construct(
        private int $lecture_id,
        private string $body,
        private int $student_id,
        private ?UploadedFile $file
    )
    {
    }

    public function getLectureId(): int
    {
        return $this->lecture_id;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStudentId(): int
    {
        return $this->student_id;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file ?? null;
    }
}
