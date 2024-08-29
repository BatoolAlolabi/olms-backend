<?php

namespace App\Domain\Sessions\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class SessionDTO extends Data
{
    public function __construct(
    public ?string $name,
    public ?string $date,
    public ?string $time,
    public ?string $max_capacity,
    public int $lesson_id,
    public ?int $duaration,
    public ?int $section_id,
    public ?string $meet_url
    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['name'] ?? null,
            $request['date'] ?? null,
            $request['time'] ?? null,
            $request['max_capacity'] ?? null,
            $request['lesson_id'] ?? null,
            $request['duaration'] ?? null,
            $request['section_id'] ?? null,
            $request['meet_url'] ?? null,
        );
    }


}
