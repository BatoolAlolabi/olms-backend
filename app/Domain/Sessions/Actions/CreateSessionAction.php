<?php

namespace App\Domain\Sessions\Actions;

use App\Domain\Sessions\DTO\SessionDTO;
use App\Models\Session;
use Spatie\LaravelData\Data;

class CreateSessionAction extends Data
{
    public static function execute(SessionDTO $DTO){
        $session = new Session($DTO->toArray());
        $session->save();
        return $session;
    }

}
