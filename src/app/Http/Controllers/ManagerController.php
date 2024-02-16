<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Services\ShopService;
use App\Services\ReservationService;
use App\Http\Requests\ShopInfoRequest;

class ManagerController extends Controller
{
    private $shopService;
    private $reservationService;

    public function __construct(ShopService $shopService, ReservationService $reservationService)
    {
        $this->shopService = $shopService;
        $this->reservationService = $reservationService;
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
        [$areas, $genres] = $this->shopService->getShopInfoRegisterForm();
        return view("manager.shopInfo", compact("areas", "genres"));
    }

    public function registerShopInfo(ShopInfoRequest $request): RedirectResponse
    {
        $name = $request->name;
        $areaId = $request->areaId;
        $genreId = $request->genreId;
        $detail = $request->detail;
        $imagePath = $request->imagePath;

        if ($this->shopService->registerShopInfo($name, $areaId, $genreId, $detail, $imagePath)) {
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
        [$shop, $image, $areas, $genres] = $this->shopService->getShopInfoModifyForm($request->shopId);
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
        if ($this->shopService->modifyShopInfo($id, $name, $areaId, $genreId, $detail, $imagePath)) {
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

    public function reservationList(Request $request): View
    {
        $shopId = $request->shopId;
        [$shop, $reservationsToday, $reservationsAfterToday] = $this->reservationService->getReservationList($shopId);
        return view("manager.reservation", compact("shop", "reservationsToday", "reservationsAfterToday", "shopId"));
    }

    public function userCame(Request $request): RedirectResponse
    {
        $shopId = $request->shopId;
        $reservationId = $request->reservationId;
        $this->reservationService->userCame($reservationId);
        return redirect("/manager/shop/reservation?shopId=" . $shopId);
    }
}
