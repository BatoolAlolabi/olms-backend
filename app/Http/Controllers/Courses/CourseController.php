<?php

namespace App\Http\Controllers\Courses;

use App\Domain\Courses\Actions\CreateCourseAction;
use App\Domain\Courses\Actions\UpdateCourseAction;
use App\Domain\Courses\DTO\CourseDTO;
use App\Domain\Grades\DTO\GradesDTO;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Session;
use App\Models\Sessions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['category','teacher','sections.sessions.lesson','project'])->get();
        return response()->json(Response::success($courses->toArray()),200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required','string'],
            'description' => ['nullable','string'],
            'started_at' => ['string','nullable'],
            'price' => ['numeric','nullable'],
            'user_teacher_id' => ['integer','nullable','exists:users,id'],
            'category_id' => ['required','integer','exists:categories,id'],
            'photo_path' => ['string','nullable'],
            'days_of_week' => ['array','nullable'],
            'lessons_count' => ['integer','nullable'],
            'sections' => ['array','nullable'],
            'sections.*.name' => ['string'],
            'sections.*.days_of_week' => ['array','required'],
            'sections.*.days_of_week.*.day' => ['integer','required'],
            'sections.*.days_of_week.*.time' => ['string','required'],
            'sections.*.days_of_week.*.duration' => ['integer','required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $courseDTO = CourseDTO::fromRequest($request->all());
        $course = CreateCourseAction::execute($courseDTO);
        if($request->input('sections') && $request->input('lessons_count')){

        $this->createLessons($course,$request->input('sections'),$request->input('lessons_count'));

        }

        return response()->json(Response::success($course->toArray()),200);


    }

    protected function createLessons(Course $course,$sections,$lessons_count)
{
    $startDate = Carbon::parse($course->started_at);
    $lessonDate = $startDate;
    foreach($sections as $section){
        $section = Section::create([
            'course_id' => $course->id,
            'name' => $section['name'],
            'days_of_week' => $section['days_of_week']
        ]);

        $row = [
            'started_at' => $course->started_at,
            'section_id' => $section->id,
            'days_of_week' => $section['days_of_week']
        ];

        $new_sections[] = $row;
    }

    $lessons_count = 10;  // عدد الدروس المطلوبة
    $lessonIndex = 1; // لتعقب الدروس
    while ($lessonIndex <= $lessons_count) {
        $lesson = Lesson::firstOrCreate([
            'course_id' => $course->id,
            'name' => $course->name . ' - ' . $lessonIndex
        ]);
        $lessonIndex++;
        foreach ($new_sections as $key =>  $section) {
            $currentDate = Carbon::parse($section['started_at']);
                // إنشاء درس إذا لم يتم إنشاؤه بعد
             $sessionCreatedForSection = false;
             while(!$sessionCreatedForSection){
                foreach($section['days_of_week'] as $day){
                    if($currentDate->dayOfWeek == $day['day']){
                    // إنشاء الجلسة للقسم في التاريخ المحدد
                    Session::create([
                        'lesson_id' => $lesson->id,
                        'date' => $currentDate->toDateString(),
                        'section_id' => $section['section_id'],
                        'time' => $day['time'],
                        'duaration' => $day['duration']
                    ]);
                    $sessionCreatedForSection = true;
                    break;
                    }
                }
                // if (in_array($currentDate->dayOfWeek, $section['days_of_week'])) {

                // }
                $currentDate->addDay();
                $new_sections[$key]['started_at'] = $currentDate->toDateString();
             }
             }

    }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::with(['category','sections.sessions.lesson','teacher','project'])->find($id);
        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found',
                    ], 404);
                }
        return response()->json(Response::success($course->toArray()),200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['nullable','string'],
            'description' => ['nullable','string'],
            'started_at' => ['string','nullable'],
            'price' => ['numeric','nullable'],
            'user_teacher_id' => ['integer','nullable','exists:users,id'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'photo_path' => ['string','nullable'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $course = Course::find($id);
        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found',
                    ], 404);
                }
        $courseDTO = CourseDTO::fromRequest($request->all());
        $course = UpdateCourseAction::execute($course,$courseDTO);
        return response()->json(Response::success($course->toArray()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $course = Course::query()->find($id);
        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'course not found',
                    ], 404);
                }
        $course->lessons()->delete();
        $course->sections()->delete();
        $course->delete();
        return response()->json(Response::success($course->toArray()),200);
    }

    public function get_category_courses(int $category_id){
        $validator = Validator::make(['category_id' => $category_id],
        [
            'category_id' => ['required','integer','exists:categories,id']
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $courses = Course::with(['category', 'teacher','sections.sessions','project'])->where('category_id',$category_id)->get();
        return response()->json(Response::success($courses->toArray()),200);
    }
}
