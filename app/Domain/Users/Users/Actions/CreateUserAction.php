<?php

namespace App\Domain\Users\Users\Actions;

use App\Domain\Users\Users\DTO\UserDTO;
use App\Models\User;

class CreateUserAction
{
    public static function execute(UserDTO $userDTO){
        $user = new User($userDTO->toArray());
        $user->save();
        return $user;
    }

}
