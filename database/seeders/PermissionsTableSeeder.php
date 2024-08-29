<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [

            [

                'name' => 'SUPER_ADMIN',
            ],
            [

                'name' => 'SHOW_EMPLOYEE',
            ],
            [

                'name' => 'CREATE_EMPLOYEE',
            ],
            [

                'name' => 'UPDATE_EMPLOYEE',
            ],
            [

                'name' => 'SHOW_STUDENT',
            ],
            [

                'name' => 'CREATE_STUDENT',
            ],
            [

                'name' => 'UPDATE_STUDENT',
            ],
            [

                'name' => 'DELETE_STUDENT',
            ],
            [

                'name' => 'SHOW_TEACHER',
            ],
            [

                'name' => 'CREATE_TEACHER',
            ],
            [
                'name' => 'UPDATE_TEACHER'
            ],
            [
                'name' => 'DELETE_TEACHER'
            ],
            [
                'name' => 'SHOW_COURSE'
            ],
            [
                'name' => 'CREATE_COURSE'
            ],
            [
                'name' => 'UPDATE_COURSE'
            ],
            [
                'name' => 'DELETE_COURSE'
            ],
            [
                'name' => 'SHOW_REGISTERATION'
            ],
            [
                'name' => 'CREATE_REGISTERATION'
            ],
            [
                'name' => 'UPDATE_REGISTERATION'
            ],
            [
                'name' => 'DELETE_REGISTERATION'
            ],
            [
                'name' => 'SHOW_MY_COURSES'
            ],
            [
                'name' => 'SHOW_CATEGORY',
            ],
            [
                'name' => 'CREATE_CATEGORY'
            ],
            [
                'name' => 'UPDATE_CATEGORY'
            ],
            [
                'name' => 'DELETE_CATEGORY'
            ],
            [
                'name' => 'SHOW_FINANCE'
            ],
            [
                'name' => 'CREATE_DEPOSIT'
            ],
            [
                'name' => 'SHOW_TRANSACTIONS'
            ],
            [
                'name' => 'SHOW_PROFILE'
            ],
            [
                'name' => 'SHOW_MY_REGISTERATION'
            ],
            [
                'name' => 'SHOW_COURSES'
            ],
            [
                'name'  => 'REGISTER_COURSE'
            ]


        ];
        foreach($permissions as $permission){
            Permission::updateOrCreate(['name'=>$permission['name']],$permission);
        }
    }
}
