<?php

namespace App\Domain\Sessions\Actions;

use App\Domain\Sessions\DTO\SessionDTO;
use App\Models\Sessions;
use Spatie\LaravelData\Data;

class CreateSession extends Data
{
    public static function execute(SessionDTO $DTO){
        $session = new Sessions($DTO->toArray());
        $session->save();
        return $session;
    }

}
