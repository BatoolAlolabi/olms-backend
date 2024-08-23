<?php

namespace App\Domain\Financial\Financial\DTO;

use Spatie\LaravelData\Data;

class FinancialDTO extends Data
{
    public function __construct(
    public ?float $deposit_Total,
    public ?float $withdrawal_Total,
    public ?float $total_balance,
    ){}

    public static function fromRequest($request)
    {
        return new self(
            $request['deposit_Total'] ?? null,
            $request['withdrawal_Total'] ?? null,
            $request['total_balance'] ?? null,
        );
    }


}
