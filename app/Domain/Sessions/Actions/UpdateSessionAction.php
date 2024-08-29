<?php

namespace App\Domain\Sessions\Actions;

use App\Domain\Sessions\DTO\SessionDTO;
use App\Models\Session;
use Spatie\LaravelData\Data;

class UpdateSessionAction extends Data
{
    public static function execute(Session $session, SessionDTO $DTO){
        $session->update(array_filter($DTO->toArray()));
        return $session;
    }

}
