<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $teacher_permissions = Permission::whereIn('name',[
            'SHOW_PROJECTS','CREATE_COURSE','SHOW_COURSE','UPDATE_COURSE','DELETE_COURSE','SHOW_REGISTERATION',
            'CREATE_REGISTERATION','UPDATE_REGISTERATION','DELETE_REGISTERATION','SHOW_MY_COURSES',
            'SHOW_CATEGORY','CREATE_CATEGORY','UPDATE_CATEGORY','DELETE_CATEGORY','SHOW_USERS','SHOW_COURSES',
            'SHOW_PROJECTS','SHOW_PROFILE'
        ])->get();
        $student_permissions = Permission::whereIn('name',[
            'SHOW_CATEGORY','SHOW_PROFILE','SHOW_MY_COURSES','SHOW_MY_REGISTERATION',
            'SHOW_COURSES','REGISTER_COURSE '
        ])->pluck('id')->toArray();
        Role::findOrFail(2)->permissions()->sync($teacher_permissions);
        Role::findOrFail(3)->permissions()->sync($student_permissions);
    }
}
