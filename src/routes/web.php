<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopController::class, 'showShopList']);
Route::get('/menu', [ShopController::class, 'showMenu']);
Route::get('/search', [ShopController::class, 'search']);
Route::get('/detail', [ShopController::class, 'detail']);
Route::get('/thanks', [RegisterController::class, 'showThanks']);
Route::middleware('auth')->group(function () {
    Route::middleware("role:user")->group(function () {
        Route::post('/like', [UserController::class, 'like']);
        Route::post('/unlike', [UserController::class, 'unlike']);
        Route::get('/my-page', [UserController::class, 'myPage']);
        Route::group(['prefix' => '/reservation'], function () {
            Route::post('/', [ReservationController::class, 'reserve']);
            Route::get('/completed', [ReservationController::class, 'reserveCompleted']);
            Route::get('/failed', [ReservationController::class, 'reserveFailed']);
            Route::post('/delete', [ReservationController::class, 'deleteReservation']);
            Route::get('/delete/completed', [ReservationController::class, 'deleteReservationCompleted']);
            Route::get('/modify', [ReservationController::class, 'showModifyReservationPage']);
            Route::post('/modify', [ReservationController::class, 'modifyReservation']);
            Route::get('/modify/completed', [ReservationController::class, 'reservationModifyCompleted']);
            Route::get('/modify/failed', [ReservationController::class, 'reservationModifyFailed']);
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::middleware("role:manager")->group(function () {
        Route::prefix("/manager")->group(function () {
            Route::get("/", [ManagerController::class, "dashboard"]);
            Route::get("/search", [ManagerController::class, "search"]);
            Route::prefix("/shop")->group(function () {
                Route::prefix("/register")->group(function () {
                    Route::get("/", [ManagerController::class, "registerShopInfoForm"]);
                    Route::post("/", [ManagerController::class, "registerShopInfo"]);
                    Route::get("/completed", [ManagerController::class, "registerShopCompleted"]);
                    Route::get("/failed", [ManagerController::class, "registerShopFailed"]);
                });
                Route::prefix("/modify")->group(function () {
                    Route::get("/", [ManagerController::class, "modifyShopInfoForm"]);
                    Route::post("/", [ManagerController::class, "modifyShopInfo"]);
                    Route::get("/completed", [ManagerController::class, "modifyShopInfoCompleted"]);
                    Route::get("/failed", [ManagerController::class, "modifyShopInfoFailed"]);
                });
                Route::get("/reservation", [ManagerController::class, "reservationList"]);
            });
        });
    });
});
