<?php

namespace App\Http\Controllers\Sections;

use App\Domain\Lessons\Actions\CreateLessonAction;
use App\Domain\Lessons\Actions\UpdateLessonsAction;
use App\Domain\Lessons\DTO\LessonDTO;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionsController extends Controller
{

    public function sections_of_course($course_id){
        $course = Course::find($course_id);
        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found',
                    ], 404);
                }
        $sections = Section::query()->where('course_id',$course_id)->get();
        return response()->json(Response::success($sections->toArray()));
    }

}
