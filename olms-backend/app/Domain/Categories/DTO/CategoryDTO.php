<?php

namespace App\Domain\Categories\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CategoryDTO extends Data
{
    public function __construct(
    public string $name,
    public ?string $type,
    public ?string $description,
    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['name'] ?? null,
            $request['type'] ?? null,
            $request['description'] ?? null,

        );
    }


}
