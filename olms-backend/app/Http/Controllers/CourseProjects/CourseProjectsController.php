<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\CourseProjects;
use Illuminate\Support\Facades\Validator;
use App\Domain\CourseProjects\Actions\CreateCourseProjects;
use App\Domain\CourseProjects\DTO\CourseProjectsDTO;

class CourseProjectsController extends Controller
{    /**
    * Display a listing of the resource.
    */
   public function index()
   {
       $CourseProjects = CourseProjects::all();
       return response()->json(Response::success($CourseProjects->toArray()),200);
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
            'file' => ['string','nullable'],
            'start_date' => ['date','nullable'],
            'end_date' => ['date','nullable'],

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $CourseProjectsDTO = CourseProjectsDTO::fromRequest($request->all());
        $CourseProjects = CreateCourseProjects::execute($CourseProjectsDTO);
        return response()->json(Response::success($CourseProjects->toArray()),200);
    }
}
