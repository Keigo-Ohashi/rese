<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Services\ShopService;
use App\Http\Requests\ReservationRequest;

class ShopController extends Controller
{
    private $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function showShopList(Request $request): View
    {
        session()->put('back', '/');
        session()->forget(['areaId', 'genreId', 'shopName']);
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
        session()->put('back', '/search?areaId=' . $areaId . '&genreId=' . $genreId . '&shopName=' . $shopName);
        $referrer = '/search?areaId=' . $areaId . '&genreId=' . $genreId . '&shopName=' . $shopName;
        session()->put(compact('areaId', 'genreId', 'shopName'));

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

    public function detail(string $shopId): View
    {

        $areaId = session('areaId');
        $genreId = session('genreId');
        $shopName = session('shopName');

        $userId = Auth::id();
        [$shop, $image] = $this->shopService->getShopInfo($shopId, $userId);
        if (is_null($shop)) {
            return view('shop.notFound');
        }
        $referrer = '/detail/' . $shopId;
        return view('shop.detail', compact('shop', 'image',  'referrer'));
    }

    public function myPage(): View
    {
        $userId = Auth::id();
        [$shops, $images, $reservations] = $this->shopService->getMyPageInfo($userId);
        session()->put('back', '/my-page');
        $referrer = '/my-page';
        return view('auth.myPage', compact('shops', 'images', 'reservations', 'referrer'));
    }
}
