<?php

namespace App\Http\Controllers;

use App\Domain\Lessons\Actions\CreateLessonAction;
use App\Domain\Lessons\Actions\UpdateLessonsAction;
use App\Domain\Lessons\DTO\LessonDTO;
use App\Helpers\Response;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::all();
        return response()->json(Response::success($lessons->toArray()),200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'course_id' => ['requird','integer','exists:courses,id'],
            'name'  => ['string','required'],
            'lesson_type_id' => ['integer','required','excists:lesson_types,id'],
            'description' => ['nullable','string'],
            'file'  => ['nullable', 'string']
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ],422);
        }

        $lessonDTO = LessonDTO::fromRequest($request->all());
        $lesson = CreateLessonAction::execute($lessonDTO);

        return response()->json(Response::success($lesson->toArray()),200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'course_id' => ['requird','integer','exists:courses,id'],
            'name'  => ['string','required'],
            'lesson_type_id' => ['integer','required','excists:lesson_types,id'],
            'description' => ['nullable','string'],
            'file'  => ['nullable', 'string']
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ],422);
        }

        $lesson = Lesson::query()->find($id);
        if(!$lesson){
            return response()->json([
                'success' => false,
                'message' => 'lesson not found',
            ],404);
        }
         $lessonDTO = LessonDTO::fromRequest($request->all());
         $lesson = UpdateLessonsAction::execute($lesson,$lessonDTO);
         return response()->json(Response::success($lesson->toArray()),200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::query()->find($id);
        if (!$lesson) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson not found',
                    ], 404);
                }
        $lesson->delete();
        return response()->json(Response::success($lesson->toArray()),200);
    }
}
