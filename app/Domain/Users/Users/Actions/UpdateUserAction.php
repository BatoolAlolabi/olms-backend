<?php

namespace App\Domain\Users\Users\Actions;

use App\Domain\Users\Users\DTO\UserDTO;
use App\Models\User;

class UpdateUserAction
{
    public static function execute(User $user,UserDTO $userDTO){
        $user->update($userDTO->toArray());
        return $user;
    }

}
