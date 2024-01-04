<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Services\ShopService;



class ShopController extends Controller
{
    private $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function showShopList(): View
    {
        [$shops, $areas, $genres] = $this->shopService->getShopListInfo();
        return view('shop.list', compact('shops', 'areas', 'genres'));
    }
}
