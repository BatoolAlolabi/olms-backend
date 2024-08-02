<?php

namespace App\Http\Controllers\Courses;

use App\Domain\Courses\Actions\CreateCourseAction;
use App\Domain\Courses\Actions\UpdateCourseAction;
use App\Domain\Courses\DTO\CourseDTO;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['category', 'teacher'])->get();
        return response()->json(Response::success($courses->toArray()), 200);
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'started_at' => ['string', 'nullable'],
            'price' => ['numeric', 'nullable'],
            'user_teacher_id' => ['integer', 'nullable', 'exists:users,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'photo_path' => ['string', 'nullable']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $courseDTO = CourseDTO::fromRequest($request->all());
        $course = CreateCourseAction::execute($courseDTO);
        return response()->json(Response::success($course->toArray()), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'started_at' => ['string', 'nullable'],
            'price' => ['numeric', 'nullable'],
            'user_teacher_id' => ['integer', 'nullable', 'exists:users,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'photo_path' => ['string', 'nullable']
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
        $course = UpdateCourseAction::execute($course, $courseDTO);
        return response()->json(Response::success($course->toArray()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::query()->find($id);
        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found',
            ], 404);
        }
        $course->delete();
        return response()->json(Response::success($course->toArray()), 200);
    }

    public function get_category_courses(int $category_id)
    {
        $validator = Validator::make(
            ['category_id' => $category_id],
            [
                'category_id' => ['required', 'integer', 'exists:categories,id']
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $courses = Course::with(['category', 'teacher'])->where('category_id', $category_id)->get();
        return response()->json(Response::success($courses->toArray()), 200);
    }
}
