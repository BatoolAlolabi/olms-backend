<?php

namespace App\Http\Controllers\StudentRegisterations;

use App\Domain\Financial\Transactions\Actions\CreateTransactionAction;
use App\Domain\Financial\Transactions\DTO\TransactionDTO;
use App\Domain\Grades\Actions\CreateGradeAction;
use App\Domain\Grades\DTO\GradesDTO;
use App\Domain\StudentRegisterations\Actions\CreateStudentRegisterationAction;
use App\Domain\StudentRegisterations\DTO\StudentRegisterationDTO;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Financial;
use App\Models\Lesson;
use App\Models\StudentCourseRegistration;
use App\Models\StudentSection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StudentRegistrationController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'course_id' => ['required','exists:courses,id'],
            'section_id' =>  ['required','exists:sections,id']
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ],422);
        }
        $OldstudentRegisteration = StudentCourseRegistration::query()
        ->where('course_id',$request->input('course_id'))
        ->where('student_id',auth('api')->id())->first();
        if(is_object($OldstudentRegisteration)){
            if (!$OldstudentRegisteration) {
                return response()->json([
                    'success' => false,
                    'message' => 'already registered',
                        ], 422);
                    }
        }
        $course = Course::find($request->input('course_id'));
        $financial = Financial::where('user_id',auth('api')->id())->first();
        if($financial->total_balance < $course->price){
            return response()->json([
                'success' => false,
                'errors' => 'no enough balance',
            ],422);
        }
        $transactionDTO = TransactionDTO::fromRequest([
            'amount' => $course->price,
            'is_deposit' => false,
            'date'  => now()->toDateTimeString(),
            'financial_id' => $financial->id,
        ]);
        $transaction = CreateTransactionAction::execute($transactionDTO);
        $financial->total_balance -= $course->price;
        $financial->withdrawal_Total += $course->price;
        $financial->save();
        $studentRegisterationDTO = StudentRegisterationDTO::fromRequest([
            'course_id' => $course->id,
            'student_id' => auth('api')->id(),
            'registeration_date' => now()->toDateTimeString(),
            'transaction_id' => $transaction->id

        ]);
        $studentRegisteration = CreateStudentRegisterationAction::execute($studentRegisterationDTO);
        $gradeDTO = GradesDTO::fromRequest([
            'course_id' => $course->id,
            'student_id' => auth('api')->id()
        ]);
        CreateGradeAction::execute($gradeDTO);
        $lessons = Lesson::query()->where('course_id',$course->id)->get();
        foreach($lessons as $lesson){
            $gradeDTO = GradesDTO::fromRequest([
                'lesson_id' => $lesson->id,
                'student_id' => auth('api')->id()
            ]);
            CreateGradeAction::execute($gradeDTO);
        }
        StudentSection::create([
            'student_id' => auth('api')->id(),
            'section_id' => $request->input('section_id')
        ]);
        return response(Response::success($studentRegisteration->toArray()),200);

    }

    public function index(){
        $registeration = StudentCourseRegistration::with(['course','student','transaction'])->get();
        return response()->json(Response::success($registeration->toArray()));
    }

    public function my_registerations(){
        $registeration = StudentCourseRegistration::with(['course','transaction'])
        ->where('student_id',auth('api')->id())->get();
        return response()->json(Response::success($registeration->toArray()));
    }
}
