<?php

namespace App\Domain\StudentProjects\Actions;

use App\Domain\StudentProjects\DTO\StudentProjectsDTO;
use App\Models\StudentProjects;
use Spatie\LaravelData\Data;

class UpdateStudentProjectAction extends Data
{
    public static function execute(StudentProjects $studentProjects,StudentProjectsDTO $DTO){
        $studentProjects->update($DTO->toArray());
        return $studentProjects;
    }

}
