<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\RegisterManagerRequest;
use App\Services\AdminService;

// use App\Services\AdminService;

class AdminController extends Controller
{
    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function dashboard(): View
    {
        return view("admin.dashboard");
    }

    public function registerManager(RegisterManagerRequest $request): RedirectResponse
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $this->adminService->registerManager($name, $email, $password);
        return redirect("/admin/register/completed");
    }

    public function registerManagerCompleted(): View
    {
        return view("admin.completed");
    }
}
