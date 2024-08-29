<?php

namespace App\Domain\Financial\Transactions\Actions;

use App\Domain\Financial\Transactions\DTO\TransactionDTO;
use App\Models\Transaction;
use Spatie\LaravelData\Data;

class CreateTransactionAction extends Data
{
    public static function execute(TransactionDTO $DTO){
        $transaction = new Transaction($DTO->toArray());
        $transaction->save();
        return $transaction;
    }

}
