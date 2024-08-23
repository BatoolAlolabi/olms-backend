<?php

namespace App\Domain\Courses\Actions;

use App\Domain\Courses\DTO\CourseDTO;
use App\Models\Course;
use Spatie\LaravelData\Data;

class CreateCourseAction extends Data
{
    public static function execute(CourseDTO $DTO){
        $course = new Course($DTO->toArray());
        $course->save();
        return $course;
    }

}
