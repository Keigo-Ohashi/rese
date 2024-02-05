<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Services\ShopService;
use App\Services\ManagerService;
use App\Http\Requests\RegisterShopInfoRequest;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    private $shopService;
    private $managerService;

    public function __construct(ShopService $shopService, ManagerService $managerService)
    {
        $this->shopService = $shopService;
        $this->managerService = $managerService;
    }

    public function dashBoard(): View
    {
        session()->put('back', '/');
        session()->forget(['areaId', 'genreId', 'shopName']);
        [$shops, $areas, $genres, $images] = $this->shopService->getShopListInfo(null, null, null, null);
        $referrer = '/';
        return view('manager.dashboard', compact('shops', 'areas', 'genres', 'images', 'referrer'));
    }

    public function search(Request $request): View
    {
        $areaId = $request->areaId;
        $genreId = $request->genreId;
        $shopName = $request->shopName;
        session()->put('back', '/search?areaId=' . $areaId . '&genreId=' . $genreId . '&shopName=' . $shopName);
        $referrer = '/search?areaId=' . $areaId . '&genreId=' . $genreId . '&shopName=' . $shopName;
        session()->put(compact('areaId', 'genreId', 'shopName'));

        [$shops, $areas, $genres, $images] = $this->shopService->getShopListInfo($areaId, $genreId, $shopName, null);
        return view('manager.dashboard', compact('shops', 'areas', 'genres', 'images', 'referrer'));
    }

    public function registerShopInfoForm(): View
    {
        [$areas, $genres] = $this->managerService->getShopInfoRegisterForm();
        return view("manager.shopInfo", compact("areas", "genres"));
    }

    public function registerShopInfo(RegisterShopInfoRequest $request): RedirectResponse
    {
        $name = $request->name;
        $areaId = $request->areaId;
        $genreId = $request->genreId;
        $detail = $request->detail;
        $image = $request->file('image');
        var_dump($image);
        if ($this->managerService->registerShopInfo($name, $areaId, $genreId, $detail, $image)) {
            return redirect('/manager/shop/register/completed');
        }
        return redirect('/manager/shop/register/failed');
    }

    public function registerShopCompleted(): View
    {
        return view("manager.register.completed");
    }

    public function registerShopFailed(): View
    {
        return view("manager.register.failed");
    }
}
