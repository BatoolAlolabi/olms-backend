<?php

namespace App\Domain\Users\Users\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UserDTO extends Data
{
    public function __construct(
    public string $name,
    public string $email,
    public string $password,
    public ?int $role_id,
    public ?string $national_number,
    public ?string $central_number,
    public ?int $financial_id,
    public ?string $surname,
    public ?string $birth_date,
    public ?string $father_name,
    public ?string $mother_name,
    public ?string $personal_picture,
    ){

    }

    public static function fromRequest($request)
    {
        return new self(
            $request['name'] ?? null,
            $request['email'] ?? null,
            isset($request['password']) ? Hash::make($request['password']):null,
            $request['role_id'] ?? null,
            $request['national_number'] ?? null,
            $request['central_number'] ?? null,
            $request['financial_id'] ?? null,
            $request['surname'] ?? null,
            $request['birth_date'] ?? null,
            $request['father_name'] ?? null,
            $request['mother_name'] ?? null,
            $request['personal_picture'] ?? null,
        );
    }


}
