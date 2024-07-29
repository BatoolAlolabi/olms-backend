<?php

namespace App\Domain\Courses\DTO;

use Spatie\LaravelData\Data;

class CourseDTO extends Data
{
    public function __construct(
    public string $name,
    public ?string $description,
    public ?string $started_at,
    public ?float $price,
    public ?int $user_teacher_id,
    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['name'] ?? null,
            $request['description'] ?? null,
            $request['started_at'] ?? null,
            $request['price'] ?? null,
            $request['user_teacher_id'] ?? null
        );
    }


}
