<?php

namespace App\Http\Controllers\Registerations;

use App\Domain\Registerations\Actions\CreateRegisterationAction;
use App\Domain\Registerations\Actions\UpdateRegisterationAction;
use App\Domain\Registerations\DTO\RegisterationDTO;
use App\Domain\StudentRegisterations\DTO\StudentRegisterationDTO;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Registeration;
use App\Models\StudentCourseRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterationController extends Controller
{
    public function index(){
        $registeration = Registeration::with('courses')->get();
        return response(Response::success($registeration->toArray()),200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'started_at' => 'string|required',
            'end_at' => 'required|string',
            'courses' => 'array',
            'courses.*' => 'integer|exists:courses,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $registerationDTO = RegisterationDTO::fromRequest($request->all());
        $registeration = CreateRegisterationAction::execute($registerationDTO);
        $registeration->courses()->sync($request->input('courses'));
        return response(Response::success($registeration->toArray()),200);
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'started_at' => 'string|required',
            'end_at' => 'required|string',
            'courses' => 'array',
            'courses.*' => 'integer|exists:courses,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $registeration = Registeration::find($id);
        if (!$registeration) {
            return response()->json([
                'success' => false,
                'message' => 'registeration not found',
                    ], 404);
                }
        $registerationDTO = RegisterationDTO::fromRequest($request->all());
        $registeration = UpdateRegisterationAction::execute($registeration,$registerationDTO);
        $registeration->courses()->sync($request->input('courses'));
        return response(Response::success($registeration->toArray()),200);
    }

    public function destroy($id){
        $registeration = Registeration::query()->find($id);
        if (!$registeration) {
            return response()->json([
                'success' => false,
                'message' => 'registeration not found',
                    ], 404);
                }
        $registeration->courses()->sync([]);
        $registeration->delete();
        return response()->json(Response::success($registeration->toArray()),200);
    }

    public function students_of_course($course_id){
        $registerations = StudentCourseRegistration::with(['student'])->where('course_id',$course_id)->get();
        return response()->json(Response::success($registerations->toArray()),200);

    }

}
