<?php

namespace App\Domain\Courses\Actions;

use App\Domain\Courses\DTO\CourseDTO;
use App\Models\Course;
use Spatie\LaravelData\Data;

class UpdateCourseAction extends Data
{
    public static function execute(Course $course,CourseDTO $DTO){
        $course->update($DTO->toArray());
        return $course;
    }

}
