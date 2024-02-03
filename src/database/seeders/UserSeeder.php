<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(["name" => "admin"]);

        $managerRole = Role::create(["name" => "manager"]);

        $userRole = Role::create(["name" => "user"]);

        User::create([
            "name" => "管理者",
            "email" => "admin@sample.com",
            "password" => Hash::make("AdminPass"),
        ])->assignRole($adminRole);

        $managers = [
            [
                "name" => "マネージャー1",
                "email" => "manager1@sample.com",
                "password" => Hash::make("ManagerPass"),
            ],
            [
                "name" => "マネージャー2",
                "email" => "manager2@sample.com",
                "password" => Hash::make("ManagerPass"),
            ]
        ];

        foreach ($managers as $manager) {
            User::create($manager)->assignRole($managerRole);
        }

        $users = [
            [
                "name" => "ユーザー1",
                "email" => "user1@sample.com",
                "password" => Hash::make("UserPass"),
            ],
            [
                "name" => "ユーザー2",
                "email" => "user2@sample.com",
                "password" => Hash::make("UserPass"),
            ],
            [
                "name" => "ユーザー3",
                "email" => "user3@sample.com",
                "password" => Hash::make("UserPass"),
            ],
        ];

        foreach ($users as $user) {
            User::create($user)->assignRole($userRole);
        }
    }
}
