<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function like(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        $shopId = $request->shopId;
        $this->userService->likeShop($userId, $shopId);
        return redirect($request->referrer);
    }

    public function unlike(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        $shopId = $request->shopId;
        $this->userService->unlikeShop($userId, $shopId);
        return redirect($request->referrer);
    }

    public function myPage(): View
    {
        $userId = Auth::id();
        [$shops, $images, $reservations] = $this->userService->getMyPageInfo($userId);
        session()->put('back', '/my-page');
        $referrer = '/my-page';
        return view('auth.myPage', compact('shops', 'images', 'reservations', 'referrer'));
    }
}
