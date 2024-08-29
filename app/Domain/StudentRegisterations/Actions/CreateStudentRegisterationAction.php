<?php

namespace App\Domain\StudentRegisterations\Actions;

use App\Domain\StudentProjects\DTO\StudentProjectsDTO;
use App\Domain\StudentRegisterations\DTO\StudentRegisterationDTO;
use App\Models\StudentCourseRegistration;
use App\Models\StudentProjects;
use Spatie\LaravelData\Data;

class CreateStudentRegisterationAction extends Data
{
    public static function execute(StudentRegisterationDTO $DTO){
        $StudentRegisteration = new StudentCourseRegistration($DTO->toArray());
        $StudentRegisteration->save();
        return $StudentRegisteration;
    }

}
