<?php

namespace App\Domain\Grades\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GradesDTO extends Data
{
    public function __construct(
    public string $degree,
    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['degree'] ?? null,

        );
    }


}
