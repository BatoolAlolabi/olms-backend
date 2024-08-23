<?php

namespace App\Domain\Grades\Actions;

use App\Domain\Grades\DTO\GradesDTO;
use App\Models\Grades;
use Spatie\LaravelData\Data;

class CreateGrades extends Data
{
    public static function execute(GradesDTO $DTO){
        $grades = new Grades($DTO->toArray());
        $grades->save();
        return $grades;
    }

}
