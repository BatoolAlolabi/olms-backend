<?php

namespace App\Domain\Lessons\Actions;

use App\Domain\Lessons\DTO\LessonDTO;
use App\Models\Lesson;

class CreateLessonAction
{
    public static function execute(LessonDTO $DTO){
        $lesson = new Lesson($DTO->toArray());
        $lesson->save();
        return $lesson;
    }

}
