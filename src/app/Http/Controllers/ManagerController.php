<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Services\ShopService;
use App\Services\ManagerService;
use App\Http\Requests\ShopInfoRequest;
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
        session()->put('back', '/manager');
        session()->forget(['areaId', 'genreId', 'shopName']);
        [$shops, $areas, $genres, $images] = $this->shopService->getShopListInfo(null, null, null, null);
        return view('manager.dashboard', compact('shops', 'areas', 'genres', 'images'));
    }

    public function search(Request $request): View
    {
        $areaId = $request->areaId;
        $genreId = $request->genreId;
        $shopName = $request->shopName;
        session()->put('back', '/manager/search?areaId=' . $areaId . '&genreId=' . $genreId . '&shopName=' . $shopName);
        session()->put(compact('areaId', 'genreId', 'shopName'));
        [$shops, $areas, $genres, $images] = $this->shopService->getShopListInfo($areaId, $genreId, $shopName, null);
        return view('manager.dashboard', compact('shops', 'areas', 'genres', 'images'));
    }

    public function registerShopInfoForm(): View
    {
        [$areas, $genres] = $this->managerService->getShopInfoRegisterForm();
        return view("manager.shopInfo", compact("areas", "genres"));
    }

    public function registerShopInfo(ShopInfoRequest $request): RedirectResponse
    {
        $name = $request->name;
        $areaId = $request->areaId;
        $genreId = $request->genreId;
        $detail = $request->detail;
        $imagePath = session("image_path");

        if ($this->managerService->registerShopInfo($name, $areaId, $genreId, $detail, $imagePath)) {
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

    public function modifyShopInfoForm(Request $request): View
    {
        [$shop, $image, $areas, $genres] = $this->managerService->getShopInfoModifyForm($request->shopId);
        if (is_null($shop)) {
            return view("manager.modify.notFound");
        }
        return view("manager.shopInfo", compact("shop", "image", "areas", "genres"));
    }

    public function modifyShopInfo(ShopInfoRequest $request): RedirectResponse
    {
        $id = $request->id;
        $name = $request->name;
        $areaId = $request->areaId;
        $genreId = $request->genreId;
        $detail = $request->detail;
        $imagePath = $request->imagePath;
        if ($this->managerService->modifyShopInfo($id, $name, $areaId, $genreId, $detail, $imagePath)) {
            return redirect('/manager/shop/modify/completed');
        }
        return redirect('/manager/shop/modify/failed');
    }

    public function modifyShopInfoCompleted(): View
    {
        return view("manager.modify.completed");
    }

    public function modifyShopInfoFailed(): View
    {
        return view("manager.modify.failed");
    }

    public function checkReservations(Request $request): View
    {
    }
}
