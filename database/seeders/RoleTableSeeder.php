<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id'    => 1,
                'name' => 'admin',
            ],
            [
                'id'    => 2,
                'name' => 'teacher',
            ],
            [
                'id'    => 3,
                'name' => 'student',
            ],
        ];
        foreach($roles as $role){
            Role::updateOrInsert(['id' => $role['id']],$role);
        }
    }
}
