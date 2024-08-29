<?php

namespace App\Domain\Financial\Transactions\DTO;

use Spatie\LaravelData\Data;

class TransactionDTO extends Data
{
    public function __construct(
    public ?float $amount,
    public ?bool $is_deposit,
    public ?string $date,
    public ?int $financial_id,
    public ?int $registeration_id,
    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['amount'] ?? null,
            $request['is_deposit'] ?? null,
            $request['date'] ?? null,
            $request['financial_id'] ?? null,
            $request['registeration_id'] ?? null,
        );
    }


}
