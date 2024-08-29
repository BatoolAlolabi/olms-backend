<?php

namespace App\Domain\Registerations\DTO;

use Spatie\LaravelData\Data;

class RegisterationDTO extends Data
{
    public function __construct(
    public ?string $started_at,
    public ?string $end_at,

    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['started_at'] ?? null,
            $request['end_at'] ?? null,

        );
    }


}
