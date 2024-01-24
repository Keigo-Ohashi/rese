<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
        [$shops, $areas, $genres, $images] = $this->shopService->getShopListInfo(null, null, null, $userId);
        $referrer = '/';
        return view('shop.list', compact('shops', 'areas', 'genres', 'images', 'referrer'));
    }

    public function showMenu(): View
    {
        return view('menu');
    }

    public function search(Request $request): View
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            $userId = null;
        }
        $areaId = $request->areaId;
        $genreId = $request->genreId;
        $shopName = $request->shopName;
        $referrer = '/search?areaId=' . $areaId . '&genreId=' . $genreId . '&shopName=' . $shopName;

        $request->session()->put(compact('areaId', 'genreId', 'shopName'));

        [$shops, $areas, $genres, $images] = $this->shopService->getShopListInfo($areaId, $genreId, $shopName, $userId);
        return view('shop.list', compact('shops', 'areas', 'genres', 'images', 'referrer'));
    }

    public function like(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        $shopId = $request->shopId;
        $this->shopService->likeShop($userId, $shopId);
        return redirect($request->referrer);
    }

    public function unlike(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        $shopId = $request->shopId;
        $this->shopService->unlikeShop($userId, $shopId);
        return redirect($request->referrer);
    }

    public function detail($shopId): View
    {

        return view('shop.detail');
    }
}
