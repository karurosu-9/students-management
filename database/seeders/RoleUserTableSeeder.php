<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::find(1)->roles()->attach(1); // id=1のユーザーに、id=1のロールを紐づける
        User::find(2)->roles()->attach(2); // id=2のユーザーに、id=2のロールを紐づける
    }
}
