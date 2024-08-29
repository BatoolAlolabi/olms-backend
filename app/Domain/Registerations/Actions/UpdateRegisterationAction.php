<?php

namespace App\Domain\Registerations\Actions;

use App\Domain\Registerations\DTO\RegisterationDTO;
use App\Models\Registeration;
use Spatie\LaravelData\Data;

class UpdateRegisterationAction extends Data
{
    public static function execute(Registeration $registeration,RegisterationDTO $DTO){
        $registeration->update($DTO->toArray());
        return $registeration;
    }

}
