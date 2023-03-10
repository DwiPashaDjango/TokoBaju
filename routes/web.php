<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KasirController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\CheckOutController;
use App\Http\Controllers\Customer\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/check', [AuthController::class, 'login']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/get/produk/{id}', [HomeController::class, 'show']);
    Route::post('/create/cart', [HomeController::class, 'carts']);
    Route::get('/cart/json', [HomeController::class, 'get_carts']);
    Route::get('/cart/count/json', [HomeController::class, 'countCart']);
    Route::get('/checkout', [CheckOutController::class, 'index']);
    Route::get('/checkout/json', [CheckOutController::class, 'get_carts_cekout']);
    Route::get('/checkout/sum/json', [CheckOutController::class, 'get_sum_carts']);
    Route::put('/checkout/json/plus/{id}', [CheckOutController::class, 'plus']);
    Route::put('/checkout/json/minus/{id}', [CheckOutController::class, 'minus']);
    Route::get('/checkout/pay/{id}', [CheckOutController::class, 'checkOut_pay']);
    Route::get('/checkout/check/pay/{id}', [CheckOutController::class, 'showCheckOutPay']);
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('admin');

    Route::get('karyawan', [UsersController::class, 'index']);
    Route::get('karyawan/add', [UsersController::class, 'create']);
    Route::post('karyawan/add', [UsersController::class, 'store']);

    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product/add', [ProductController::class, 'create']);
    Route::get('/product/{id}', [ProductController::class, 'edit']);
    Route::post('/product/add/save', [ProductController::class, 'store']);
    Route::get('/product/add/{id}/image', [ProductController::class, 'show']);
    Route::put('/product/image/save/{id}', [ProductController::class, 'update_product_lanjutan']);
    Route::put('/product/edit/save/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);

    Route::get('/kasir', [KasirController::class, 'index']);
    Route::post('/kasir', [KasirController::class, 'store']);
    Route::get('/kasir/json', [KasirController::class, 'get_transaction']);
    Route::put('/kasir/plus/{id}', [KasirController::class, 'plusQty']);
    Route::put('/kasir/minus/{id}', [KasirController::class, 'minusQty']);
    Route::put('/kasir/{id}', [KasirController::class, 'destroy']);
    Route::get('/kasir/print/nota', [KasirController::class, 'printNota']);

    Route::get('/logout', [AuthController::class, 'logout']);
});
