<?php

namespace App\Domain\Grades\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GradesDTO extends Data
{
    public function __construct(
    public ?float $degree,
    public ?int $student_id,
    public ?int $project_id ,
    public ?int $lesson_id ,
    public ?int $course_id
    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['degree'] ?? null,
            $request['student_id'] ?? null,
            $request['project_id'] ?? null,
            $request['lesson_id'] ?? null,
            $request['course_id'] ?? null,

        );
    }


}
