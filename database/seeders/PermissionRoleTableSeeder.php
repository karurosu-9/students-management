<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_permissions = Permission::all(); // 「管理者」は『全ての権限』を付与

        $public_permissions = Permission::whereIn('title', [ // whereIn()で検索条件にIN句を絡めている
            'student_access',
            'student_create'
        ])->get(); // 「一般」は『student_access』のみ許可

        Role::find(1)->permissions()->attach($admin_permissions);
        Role::find(2)->permissions()->attach($public_permissions);
    }
}
