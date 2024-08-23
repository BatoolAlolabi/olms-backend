<?php

namespace App\Http\Controllers;
use App\Domain\Grades\Actions\CreateGrades;
use App\Domain\Grades\DTO\GradesDTO;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Grades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradesController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grades::all();
        return response()->json(Response::success($grades->toArray()),200);
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
            'degree' => ['float'],
             
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $gradesDTO = GradesDTO::fromRequest($request->all());
        $grades = CreateGrades::execute($gradesDTO);
        return response()->json(Response::success($grades->toArray()),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {

    }

}
