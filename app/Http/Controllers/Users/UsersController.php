<?php

namespace App\Http\Controllers\Users;

use App\Domain\Users\Users\Actions\CreateUserAction;
use App\Domain\Users\Users\Actions\UpdateUserAction;
use App\Domain\Users\Users\DTO\UserDTO;
use App\Enum\RolesEnum;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function profile(){
        $user = User::with('role')->find(auth('api')->id());
        return response()->json(Response::success($user->toArray()));
    }

    public function update_profile(Request $request){

        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required','unique:users,email,'.auth('api')->id().',id', 'string'],
            'national_number' => ['nullable','string'],
            'central_number' => ['nullable','string'],
            'surname' => ['nullable','string'],
            'birth_date' => ['nullable','string'],
            'father_name' => ['nullable','string'],
            'mother_name' => ['nullable','string'],
            'personal_picture' => ['nullable','string'],
            'financial_id' => ['nullable','integer','exists:financials,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

                // العثور على المستخدم وتحديث بياناته
        $user = User::find(auth('api')->id());

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
                    ], 404);
                }

        $userDTO = UserDTO::fromRequest($request->all());
        if(!isset($userDTO->personal_picture))
        $userDTO->personal_picture = '/storage/images/default_profile_image.jpg';
        $user = UpdateUserAction::execute($user,$userDTO);

        return response()->json(Response::success($user->toArray()),200);
    }

    public function index(){
        $teachers = User::query()->where('role_id',RolesEnum::ADMIN->value)->get();
        return response()->json(Response::success($teachers->toArray()));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string'],
            'email' => ['required','unique:users,email,NULL,id', 'string'],
            'password' => ['required', 'string'],
            'national_number' => ['nullable','string'],
            'central_number' => ['nullable','string'],
            'surname' => ['nullable','string'],
            'birth_date' => ['nullable','string'],
            'father_name' => ['nullable','string'],
            'mother_name' => ['nullable','string'],
            'personal_picture' => ['nullable','string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $userDTO = UserDTO::fromRequest($request->all() + ['role_id' => RolesEnum::ADMIN->value]);
        if(!isset($userDTO->personal_picture))
        $userDTO->personal_picture = '/storage/images/default_profile_image.jpg';
        $user = CreateUserAction::execute($userDTO);
        return response()->json(Response::success($user->toArray()));
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string'],
            'email' => ['required','unique:users,email,'.$id.',id', 'string'],
            'password' => ['nullable', 'string'],
            'national_number' => ['nullable','string'],
            'central_number' => ['nullable','string'],
            'surname' => ['nullable','string'],
            'birth_date' => ['nullable','string'],
            'father_name' => ['nullable','string'],
            'mother_name' => ['nullable','string'],
            'personal_picture' => ['nullable','string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found',
                    ], 404);
                }

        $userDTO = UserDTO::fromRequest($request->all());
        if(!isset($userDTO->personal_picture))
        $userDTO->personal_picture = '/storage/images/default_profile_image.jpg';
        $user = UpdateUserAction::execute($user,$userDTO);
        return response()->json(Response::success($user->toArray()),200);
    }

    public function destroy($id){
        $user = User::query()->find($id);
        if (!$user || $user->role_id != RolesEnum::ADMIN->value) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found',
                    ], 404);
                }

        $user->delete();
        return response()->json(Response::success($user->toArray()),200);
    }

}
