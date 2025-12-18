<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@info.com',
                'password' => bcrypt('xcc0504')
            ],
            [
                'name' => 'user',
                'email' => 'user@info.com',
                'password' => bcrypt('xcc0504')
            ],
        ];

        User::insert($users);
    }
}
