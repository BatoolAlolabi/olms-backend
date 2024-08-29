<?php

namespace App\Domain\StudentProjects\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class StudentProjectsDTO extends Data
{
    public function __construct(
    public string $description,
    public ?int $student_id,
    public ?int $project_id,
    public ?string $file,

    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['description'] ?? null,
            $request['student_id'] ?? null,
            $request['project_id'] ?? null,
            $request['file'] ?? null,




        );
    }


}
