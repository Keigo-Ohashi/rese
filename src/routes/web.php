<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
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
Route::middleware('auth')->group(function () {
    Route::post('/like', [ShopController::class, 'like']);
    Route::post('/unlike', [ShopController::class, 'unlike']);
    Route::post('/reserve', [ShopController::class, 'reserve']);
    Route::get('/done', [ShopController::class, 'reserveComplete']);
    Route::get('/my-page', [ShopController::class, 'myPage']);
});
