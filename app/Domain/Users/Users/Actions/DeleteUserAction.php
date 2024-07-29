<?php

namespace App\Domain\Users\Users\Actions;

use App\Domain\Users\Users\DTO\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;

class DeleteUserAction extends Data
{
    public static function execute($id){
        $user = User::query()->find($id);
        $user->delete();
        return $user;
    }

}
