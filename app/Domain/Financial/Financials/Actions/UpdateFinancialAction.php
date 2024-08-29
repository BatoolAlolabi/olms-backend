<?php

namespace App\Domain\Courses\Actions;

use App\Domain\Financial\Financial\DTO\FinancialDTO;
use App\Models\Financial;
use Spatie\LaravelData\Data;

class UpdateFinancialAction extends Data
{

    public static function execute(Financial $financial,FinancialDTO $DTO){
        $financial->update($DTO->toArray());
        return $financial;
    }

}
