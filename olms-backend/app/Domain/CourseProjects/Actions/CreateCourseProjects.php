<?php

namespace App\Domain\CourseProjects\Actions;

use App\Domain\CourseProjects\DTO\CourseProjectsDTO;
use App\Models\CourseProjects;
use Spatie\LaravelData\Data;

class CreateCourseProjects extends Data
{
    public static function execute(CourseProjectsDTO $DTO){
        $CourseProjects = new CourseProjects($DTO->toArray());
        $CourseProjects->save();
        return $CourseProjects;
    }

}
