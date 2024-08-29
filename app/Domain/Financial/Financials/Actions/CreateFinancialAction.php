<?php

namespace App\Domain\Financial\Financial\Actions;

use App\Domain\Financial\Financial\DTO\FinancialDTO;
use App\Models\Financial;
use Spatie\LaravelData\Data;

class CreateFinancialAction extends Data
{
    public static function execute(FinancialDTO $DTO){
        $financial = new Financial($DTO->toArray());
        $financial->save();
        return $financial;
    }

}
