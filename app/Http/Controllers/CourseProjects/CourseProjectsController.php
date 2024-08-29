<?php

namespace App\Http\Controllers\CourseProjects;

use App\Domain\CourseProjects\Actions\CreateCourseProjectAction;
use App\Domain\StudentProjects\DTO\StudentProjectsDTO;
use Illuminate\Http\Request;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\CourseProjects;
use Illuminate\Support\Facades\Validator;
use App\Domain\CourseProjects\Actions\CreateCourseProjects;
use App\Domain\CourseProjects\DTO\CourseProjectsDTO;
use App\Domain\Grades\Actions\CreateGradeAction;
use App\Domain\Grades\DTO\GradesDTO;
use App\Domain\StudentProjects\Actions\CreateStudentProjectAction;
use App\Domain\StudentProjects\Actions\CreateStudentProjects;
use App\Domain\StudentProjects\Actions\UpdateStudentProjectAction;
use App\Models\StudentCourseRegistration;
use App\Models\StudentProjects;

class CourseProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $CourseProjects = CourseProjects::all();
        return response()->json(Response::success($CourseProjects->toArray()), 200);
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
            'file' => ['string', 'nullable'],
            'start_date' => ['date', 'nullable'],
            'end_date' => ['date', 'nullable'],
            'course_id' => ['integer', 'exists:courses,id']

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $CourseProjectsDTO = CourseProjectsDTO::fromRequest($request->all());
        $CourseProjects = CreateCourseProjectAction::execute($CourseProjectsDTO);
        $student_ids = StudentCourseRegistration::query()->where('course_id', $request->input('course_id'))
            ->pluck('student_id')->toArray();
        foreach ($student_ids as $student_id) {
            $gradeDTO = GradesDTO::fromRequest([
                'project_id' => $CourseProjects->id,
                'student_id' => $student_id
            ]);
            CreateGradeAction::execute($gradeDTO);
        }
        return response()->json(Response::success($CourseProjects->toArray()), 200);
    }

    public function projects_of_course($course_id)
    {
        $projects = CourseProjects::with(['student_projects.student'])->where('course_id', $course_id)->get();
        return response()->json(Response::success($projects->toArray()), 200);
    }

    public function create_student_project(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => ['nullable', 'string'],
            'project_id' => ['integer', 'required', 'exists:projects,id'],
            'file'  => ['nullable', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $studentProjectDTO = StudentProjectsDTO::fromRequest($request->all());
        $studentProjectDTO->student_id = auth('api')->id();
        $student_project = StudentProjects::query()->where('student_id', $studentProjectDTO->student_id)
            ->where('project_id', $studentProjectDTO->project_id)->first();
        if (is_object($student_project)) {
            $student_project = UpdateStudentProjectAction::execute($student_project, $studentProjectDTO);
        } else {
            $studentProject = CreateStudentProjectAction::execute($studentProjectDTO);
        }

        return response()->json(Response::success($studentProject->toArray()), 200);
    }
}