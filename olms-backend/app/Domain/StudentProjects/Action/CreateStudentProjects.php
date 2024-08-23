<?php

namespace App\Domain\StudentProjects\Actions;

use App\Domain\StudentProjects\DTO\StudentProjectsDTO;
use App\Models\StudentProjects;
use Spatie\LaravelData\Data;

class CreateStudentProjects extends Data
{
    public static function execute(StudentProjectsDTO $DTO){
        $StudentProjects = new StudentProjects($DTO->toArray());
        $StudentProjects->save();
        return $StudentProjects;
    }

}
