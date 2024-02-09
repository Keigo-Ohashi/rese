<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminService
{
    private $userRepository;

    public function __construct(
        UserRepository $userRepository,

    ) {
        $this->userRepository = $userRepository;
    }

    public function registerManager(string $name, string $email, string $password): void
    {
        $manager = $this->userRepository->create($name, $email, $password);
        $managerRole = Role::where("name", "manager")->first();
        $manager->assignRole($managerRole);
    }
}
