<?php

namespace App\Domain\Grades\Actions;

use App\Domain\Grades\DTO\GradesDTO;
use App\Models\Grades;
use Spatie\LaravelData\Data;

class UpdateGradeAction extends Data
{
    public static function execute(Grades $grade,GradesDTO $DTO){

        $grade->update($DTO->toArray());
        return $grade;
    }

}
