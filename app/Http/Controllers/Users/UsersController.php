<?php

namespace App\Http\Controllers\Users;

use App\Domain\Users\Users\Actions\UpdateUserAction;
use App\Domain\Users\Users\DTO\UserDTO;
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

    public function profile()
    {
        $user = User::with('role')->find(auth()->id());
        return response()->json(Response::success($user->toArray()));
    }

    public function update_profile(Request $request)
    {

        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'unique:users,email,' . auth()->id() . ',id', 'string'],
            'password' => ['nullable', 'string'],
            'role_id'   => ['nullable', 'integer', 'exists:roles,id'],
            'national_number' => ['nullable', 'string'],
            'central_number' => ['nullable', 'string'],
            'surname' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'string'],
            'father_name' => ['nullable', 'string'],
            'mother_name' => ['nullable', 'string'],
            'personal_picture' => ['nullable', 'string'],
            'financial_id' => ['nullable', 'integer', 'exists:financials,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // العثور على المستخدم وتحديث بياناته
        $user = User::find(auth()->id());

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $userDTO = UserDTO::fromRequest($request->all());
        if (!isset($userDTO->personal_picture))
            $userDTO->personal_picture = '/storage/images/default_profile_image.jpg';
        $user = UpdateUserAction::execute($user, $userDTO);

        return response()->json(Response::success($user->toArray()), 200);
    }
}
