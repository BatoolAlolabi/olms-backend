<?php

namespace App\Domain\Lessons\DTO;

use Spatie\LaravelData\Data;

class LessonDTO extends Data
{
    public function __construct(
    public int $course_id,
    public string $name,
    public ?string $description,
    public ?string $file,

    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['course_id'] ?? null,
            $request['name'] ?? null,
            $request['description'] ?? null,
            $request['file'] ?? null,

        );
    }


}
