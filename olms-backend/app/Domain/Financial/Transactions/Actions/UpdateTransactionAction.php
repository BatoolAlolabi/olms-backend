<?php

namespace App\Domain\Financial\Transactions\Actions;

use App\Domain\Financial\Transactions\DTO\TransactionDTO;
use App\Models\Transaction;
use Spatie\LaravelData\Data;

class UpdateTransactionAction extends Data
{
    public static function execute(Transaction $transaction,TransactionDTO $DTO){
        $transaction->update($DTO->toArray());
        return $transaction;
    }

}
