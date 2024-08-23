<?php

namespace App\Domain\Lessons\Actions;


use App\Domain\Lessons\DTO\LessonDTO;
use App\Models\Lesson;

class UpdateLessonsAction
{
    public static function execute(Lesson $lesson,LessonDTO $DTO){
        $lesson->update($DTO->toArray());
        return $lesson;
    }

}
