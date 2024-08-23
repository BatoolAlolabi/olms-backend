<?php

namespace App\Domain\CourseProjects\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CourseProjectsDTO extends Data
{
    public function __construct(
    public string $name,
    public ?string $start_date,
    public ?string $end_date,
    public ?string $file,
    public ?string $description,
    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['name'] ?? null,
            $request['start_date'] ?? null,
            $request['end_date'] ?? null,
            $request['file'] ?? null,
            $request['description'] ?? null,

        );
    }


}
