<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Services\ShopService;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    private $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function showShopList(): View
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            $userId = null;
        }
        [$shops, $areas, $genres, $images] = $this->shopService->getShopListInfo($userId);
        $referrer = '/';
        return view('shop.list', compact('shops', 'areas', 'genres', 'images', 'referrer'));
    }

    public function showMenu(): View
    {
        return view('menu');
    }
}
