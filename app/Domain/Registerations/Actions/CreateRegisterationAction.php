<?php

namespace App\Domain\Registerations\Actions;

use App\Domain\Registerations\DTO\RegisterationDTO;
use App\Models\Registeration;
use Spatie\LaravelData\Data;

class CreateRegisterationAction extends Data
{
    public static function execute(RegisterationDTO $DTO){
        $registeration = new Registeration($DTO->toArray());
        $registeration->save();
        return $registeration;
    }

}
