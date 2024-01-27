<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Services\ShopService;
use App\Http\Requests\RegisterReservationRequest;

class ShopController extends Controller
{
    private $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function showShopList(Request $request): View
    {
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
        if (!is_null($areaId) or !is_null($genreId) or !is_null($shopName)) {
            $back = '/search?areaId=' . $areaId . '&genreId=' . $genreId . '&shopName=' . $shopName;
        } else {
            $back = '/';
        }
        $userId = Auth::id();
        [$shop, $image] = $this->shopService->getShopInfo($shopId, $userId);
        if (is_null($shop)) {
            return view('shop.notFound', compact('back'));
        }
        $referrer = '/detail/' . $shopId;
        return view('shop.detail', compact('shop', 'image', 'back', 'referrer'));
    }

    public function reserve(RegisterReservationRequest $request): RedirectResponse
    {
        $userId = Auth::id();
        $shopId = $request->shopId;
        $date = $request->date;
        $time = $request->time;
        $numPeople = $request->numPeople;
        $this->shopService->reserve($userId, $shopId, $date, $time, $numPeople);
        return redirect('done');
    }

    public function reserveComplete(): View
    {
        return view('shop.reserved');
    }
}
