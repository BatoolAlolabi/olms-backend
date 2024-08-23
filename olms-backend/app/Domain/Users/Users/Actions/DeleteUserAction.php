<?php

namespace App\Domain\Users\Users\Actions;

use App\Models\User;

class DeleteUserAction
{
    public static function execute($id){
        $user = User::query()->find($id);
        $user->delete();
        return $user;
    }

}
