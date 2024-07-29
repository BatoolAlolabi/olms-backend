<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Users\Users\Actions\CreateUserAction;
use App\Domain\Users\Users\DTO\UserDTO;
use App\Enum\RolesEnum;
use App\Exceptions\RequestException;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required','unique:users,email,NULL,id', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(Response::error([
                'success' => false,
                'errors' => $validator->errors(),
            ]), 422);
        }
        $userDTO = UserDTO::fromRequest($request->all());
        $userDTO->role_id = RolesEnum::STUDENT->value;
            $user = CreateUserAction::execute($userDTO);

            $permissions = Permission::query()->whereHas('roles',function($query)use ($userDTO){
                $query->where('roles.id','=',$userDTO->role_id);
            })->pluck('name')->toArray();

        $objToken = $user->createToken('MyApp',$permissions ??[] );

        return response()->json(Response::success($user->toArray() + [
            'access_token' => $objToken->plainTextToken ?? null,
        ]) );
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(Response::error([
                'success' => false,
                'errors' => $validator->errors(),
            ]), 422);
        }
        $data = $request->all();

        $user = User::with(["role"])->where('email','=',$data['email'])->first();
        if($user){
            if (Hash::check($data['password'], $user->password)){
                $permissions = Permission::query()->whereHas('roles',function($query) use($user){
                    $query->where('roles.id',$user->role_id);
                })->pluck('name')->toArray();

                $objToken = $user->createToken('MyApp',$permissions ??[] );

                return response()->json(Response::success($user->toArray() + [
                    'access_token' => $objToken->plainTextToken ?? null,
                ]));
            }

        }
        throw new RequestException('you are not authenticated,please signup and try again.',null,401);
    }

}
