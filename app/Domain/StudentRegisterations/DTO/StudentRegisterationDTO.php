<?php

namespace App\Domain\StudentRegisterations\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class StudentRegisterationDTO extends Data
{
    public function __construct(
    public string $student_id,
    public ?int $course_id,
    public ?string $registeration_date,
    public ?string $transaction_id,

    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['student_id'] ?? null,
            $request['course_id'] ?? null,
            $request['registeration_date'] ?? null,
            $request['transaction_id'] ?? null,
        );
    }


}
