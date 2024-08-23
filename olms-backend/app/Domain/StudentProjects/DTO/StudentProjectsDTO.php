<?php

namespace App\Domain\StudentProjects\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class StudentProjectsDTO extends Data
{
    public function __construct(
    public string $description,
    
    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['description'] ?? null,
            

            

        );
    }


}
