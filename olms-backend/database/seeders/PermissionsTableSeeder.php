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

                'name' => 'CATEGORY_ACCESS',
            ],
            [

                'name' => 'CATEGORY_CREATE',
            ],
            [

                'name' => 'CATEGORY_UPDATE',
            ],
            [

                'name' => 'CATEGORY_DELETE',
            ],
            [

                'name' => 'CATEGORY_SHOW',
            ],
            [

                'name' => 'COURSE_ACCESS',
            ],
            [

                'name' => 'COURSE_CREATE',
            ],
            [

                'name' => 'COURSE_UPDATE',
            ],
            [

                'name' => 'COURSE_DELETE',
            ],


        ];
        foreach($permissions as $permission){
            Permission::updateOrCreate(['name'=>$permission['name']],$permission);
        }
    }
}
