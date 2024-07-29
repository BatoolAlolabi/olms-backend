<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id' => 1 ,
                'name'         => 'Admin',
                'email' =>  'admin@admin.com',
                'password'       => bcrypt('123456'),
                'role_id'   => 1
            ]
        ];
        foreach($users as $user){
            User::updateOrInsert(['email' => $user['email']],$user);
        }
    }
}
