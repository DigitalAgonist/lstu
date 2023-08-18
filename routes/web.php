<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\UploadsController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Middleware;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RawController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForecastingController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

//ForgotPasswordController
Route::get('/forgot-password', [ForgotPasswordController::class, 'passwordRequest'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'passwordEmail'])->middleware('guest')->name('password.email');

//ResetPasswordController
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->middleware('guest')->name('password.update');

//HomeController
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/index', [HomeController::class, 'index'])->name('index');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/filter', [HomeController::class, 'filter'])->name('filter');

//ProductController
Route::get('/product/{id}', [ProductController::class, 'showProduct'])->name('product.detail');
Route::get('/product/edit/{id}', [ProductController::class, 'editProduct'])->name('product.edit');
Route::get('/new_product', [ProductController::class, 'createProduct'])->name('product.create');
Route::post('/product/edit/{id}', [ProductController::class, 'updateProduct'])->name('product.edit');
Route::post('/new_product/create', [ProductController::class, 'uploadProduct'])->name('product.upload');
Route::post('/product/{productId}/setcomponent/{rawId}', [ProductController::class, 'setComponent'])->name('product.setcomponent');


//RawController
Route::get('/new_raw', [RawController::class, 'createRaw'])->name('raw.create');
Route::get('/raws', [RawController::class, 'raws'])->name('raws');
Route::post('/new_raw/upload', [RawController::class, 'uploadRaw'])->name('raw.upload');
Route::post('/raw/{id}/update', [RawController::class, 'updateRaw'])->name('raw.update');


//ProfileController
Route::get('/profile/{id}', [ProfileController::class, 'profile'])->name('profile');
Route::get('/profiles', [ProfileController::class, 'profiles'])->name('profiles');
Route::get('/profile/{id}/data', [ProfileController::class, 'profileData'])->name('profile.data');
Route::post('/profile/avatar/upload', [ProfileController::class, 'profileUploadAvatar'])->name('profile.avatar.upload');
Route::post('/profile/{id}/setrole/{roleId}', [ProfileController::class, 'setrole'])->name('profile.setrole');
Route::post('/profile/{id}/update', [ProfileController::class, 'profileUpdate'])->name('profile.update');


//BasketController
Route::get('/basket', [BasketController::class, 'basket'])->name('basket');
Route::post('/basket/add/{id}', [BasketController::class, 'addToBasket'])->name('basket.add');
Route::post('/basket/rm/{id}', [BasketController::class, 'removeFromBasket'])->name('basket.rm');
Route::post('/basket/order', [BasketController::class, 'order'])->name('basket.order');

//OrderControler
Route::get('/orders/admin', [OrderController::class, 'allOrders'])->name('orders.admin');
Route::get('/orders/order/{id}', [OrderController::class, 'order'])->name('orders.order');
Route::get('/orders/user/{id}', [OrderController::class, 'ordersFromUser'])->name('orders.user');
Route::get('/orders/admin/filter', [OrderController::class, 'applyFilter'])->name('orders.filter');
Route::post('/orders/order/{id}/completed', [OrderController::class, 'complete'])->name('order.complete');
Route::post('/orders/order/{id}/confirmed', [OrderController::class, 'confirm'])->name('order.confirm');



//ForecastingController
Route::get('/forecasting', [ForecastingController::class, 'showPage'])->name('forecasting');
Route::post('/forecasting', [ForecastingController::class, 'forecasting'])->name('forecasting');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/{id}/data', [ProfileController::class, 'profileData'])->name('profile.data');
    Route::post('/profile/avatar/upload', [ProfileController::class, 'profileUploadAvatar'])->name('profile.avatar.upload');
    Route::post('/profile/{id}/update', [ProfileController::class, 'profileUpdate'])->name('profile.update');

    Route::get('/basket', [BasketController::class, 'basket'])->name('basket');
    Route::post('/basket/add/{id}', [BasketController::class, 'addToBasket'])->name('basket.add');
    Route::post('/basket/rm/{id}', [BasketController::class, 'removeFromBasket'])->name('basket.rm');
    Route::post('/basket/order', [BasketController::class, 'order'])->name('basket.order');

    Route::get('/orders/order/{id}', [OrderController::class, 'order'])->name('orders.order');
    Route::get('/orders/user/{id}', [OrderController::class, 'ordersFromUser'])->name('orders.user');
    Route::post('/orders/order/{id}/confirmed', [OrderController::class, 'confirm'])->name('order.confirm');
});

Route::middleware(['auth', 'employee'])->group(function () {
    Route::get('/profiles', [ProfileController::class, 'profiles'])->name('profiles');

    Route::get('/orders/admin', [OrderController::class, 'allOrders'])->name('orders.admin');
    Route::get('/orders/admin/filter', [OrderController::class, 'applyFilter'])->name('orders.filter');
    Route::post('/orders/order/{id}/completed', [OrderController::class, 'complete'])->name('order.complete');

    Route::get('/forecasting', [ForecastingController::class, 'showPage'])->name('forecasting');
    Route::post('/forecasting', [ForecastingController::class, 'forecasting'])->name('forecasting');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/product/edit/{id}', [ProductController::class, 'editProduct'])->name('product.edit');
    Route::get('/new_product', [ProductController::class, 'createProduct'])->name('product.create');
    Route::post('/new_product/create', [ProductController::class, 'uploadProduct'])->name('product.upload');
    Route::post('/product/{productId}/setcomponent/{rawId}', [ProductController::class, 'setComponent'])->name('product.setcomponent');

    Route::get('/raws', [RawController::class, 'raws'])->name('raws');
    Route::get('/new_raw', [RawController::class, 'createRaw'])->name('raw.create');
    Route::post('/new_raw/upload', [RawController::class, 'uploadRaw'])->name('raw.upload');
    Route::post('/raw/{id}/update', [RawController::class, 'updateRaw'])->name('raw.update');

    Route::get('/profiles-control', [ProfileController::class, 'profilesControl'])->name('profiles.control');
    Route::post('/profile/{id}/setrole/{roleId}', [ProfileController::class, 'setrole'])->name('profile.setrole');
});
