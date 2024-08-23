<?php

namespace App\Domain\Sessions\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class SessionDTO extends Data
{
    public function __construct(
    public string $name,
    public ?string $type,
    public ?string $time,
    public ?string $max_capacity,
    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['name'] ?? null,
            $request['type'] ?? null,
            $request['time'] ?? null,
            $request['max_capacity'] ?? null,

            

        );
    }


}
