<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;

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
Route::get('/detail/{shopId}', [ShopController::class, 'detail']);
Route::get('/thanks', [RegisterController::class, 'showThanks']);
Route::middleware("role:user")->group(function () {
    Route::post('/like', [ShopController::class, 'like']);
    Route::post('/unlike', [ShopController::class, 'unlike']);
    Route::get('/my-page', [ShopController::class, 'myPage']);
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
