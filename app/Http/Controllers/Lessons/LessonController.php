<?php

namespace App\Http\Controllers\Lessons;

use App\Domain\Lessons\Actions\CreateLessonAction;
use App\Domain\Lessons\Actions\UpdateLessonAction;
use App\Domain\Lessons\Actions\UpdateLessonsAction;
use App\Domain\Lessons\DTO\LessonDTO;
use App\Domain\Sessions\Actions\CreateSessionAction;
use App\Domain\Sessions\Actions\UpdateSessionAction;
use App\Domain\Sessions\DTO\SessionDTO;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonStudent;
use App\Models\Session;
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

    public function get_course_lessons(int $course_id){

        $course = Course::find($course_id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'course not found',
                    ], 404);
                }

        $lessons = Lesson::with(['sessions.section'])->where('course_id',$course_id)->get();
        return response()->json(Response::success($lessons->toArray()),200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'course_id' => ['required','integer','exists:courses,id'],
            'name'  => ['string','required'],
            'description' => ['nullable','string'],
            'file'  => ['nullable', 'string'],
            'sessions' => ['array','required'],
            'sessions.*.time' => ['nullable','string'],
            'sessions.*.max_capacity' => ['integer','nullable'],
            'sessions.*.date'  => ['string','nullable'],
            'sessions.*.duaration' => ['integer','nullable'],
            'sessions.*.section_id' => ['integer','exists:sections,id']
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ],422);
        }

        $lessonDTO = LessonDTO::fromRequest($request->all());
        $lesson = CreateLessonAction::execute($lessonDTO);
        $lesson->sessions()->createMany($request->input('sessions'));

        return response()->json(Response::success($lesson->toArray()),200);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $lesson = Lesson::with(['sessions.section'])->find($id);
        return response()->json(Response::success($lesson->toArray()),200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'course_id' => ['required','integer','exists:courses,id'],
            'name'  => ['string','required'],
            'description' => ['nullable','string'],
            'file'  => ['nullable', 'string'],

            'sessions' => ['array','required'],
            'sessions.*.id' => ['nullable','integer','exists:leasson_sessions,id'],
            'sessions.*.time' => ['nullable','string'],
            'sessions.*.max_capacity' => ['integer','nullable'],
            'sessions.*.date'  => ['string','nullable'],
            'sessions.*.duaration' => ['integer','nullable'],
            'sessions.*.section_id' => ['integer','exists:sections,id'],
            'sessions.*.meet_url' => ['nullable','string'],
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
         $lesson = UpdateLessonAction::execute($lesson,$lessonDTO);
         foreach($request->input('sessions') as $session){
            if(isset($session['id'])){
                $s = Session::find($session['id']);
                $sessionDTO = SessionDTO::fromRequest($session);
                $sessionDTO->lesson_id = $lesson->id;
                UpdateSessionAction::execute($s,$sessionDTO);
            }else{
                $sessionDTO = SessionDTO::fromRequest($session);
                $sessionDTO->lesson_id = $lesson->id;
                CreateSessionAction::execute($sessionDTO);
            }
         }
         return response()->json(Response::success($lesson->toArray()),200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $lesson = Lesson::query()->find($id);
        if (!$lesson) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson not found',
                    ], 404);
                }
        $lesson->grades()->delete();
        $lesson->sessions()->delete();
        $lesson->delete();
        return response()->json(Response::success($lesson->toArray()),200);
    }

    public function attend_lesson($lesson_id){
        $lesson = Lesson::query()->find($lesson_id);
        if (!$lesson) {
            return response()->json([
                'success' => false,
                'message' => 'Lesson not found',
                    ], 404);
                }
        $lesson = LessonStudent::create([
            'lesson_id' => $lesson_id,
            'student_id' => auth('api')->id()
        ]);
        return response()->json(Response::success($lesson->toArray()),200);
    }
}
