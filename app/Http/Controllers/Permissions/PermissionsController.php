<?php

namespace App\Http\Controllers\Permissions;
use App\Domain\Sessions\Actions\CreateSession;
use App\Domain\Sessions\Actions\CreateSessionAction;
use App\Domain\Sessions\DTO\SessionDTO;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{
    public function user_permissions(){
        $user = auth('api')->user();
        $role = Role::find($user->role_id);
        $permissions = Permission::query()->whereHas('roles',function($query) use($role){
            $query->where('roles.id',$role->id);
        })->get();
        return response()->json(Response::success($permissions->toArray()));
    }

}
