<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            // 管理者権限
            [
                'id' => 1,
                'title' => Role::ROLES['Admin'],
            ],

            // 一般ユーザー権限
            [
                'id' => 2,
                'title' => Role::ROLES['Public'],
            ],
        ];

        Role::insert($roles);
    }
}
