<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new \App\Models\User();
        $admin->name = 'Admin';
        $admin->email = 'admin@grtech.com';
        $admin->password = bcrypt('password');
        $admin->save();

        $user = new \App\Models\User();
        $user->name = 'User';
        $user->email = 'user@grtech.com';
        $user->password = bcrypt('password');
        $user->save();

    }
}
