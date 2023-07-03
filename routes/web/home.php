<?php

use App\Http\Controllers\Auth\AuthTokenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Profile\IndexController;
use App\Http\Controllers\Profile\TwoFactorAuthController;
use App\Http\Controllers\Profile\TokenAuthController;

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

Route::get('/', function () {
    \auth()->loginUsingId(11);
//    return \Carbon\Carbon::now()->subDays(2);
//    return \Morilog\Jalali\Jalalian::now();
});

Auth::routes(['verify' => true]);
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('/auth/token', [AuthTokenController::class, 'getToken'])->name('2fa.token');
Route::post('/auth/token', [AuthTokenController::class, 'postToken']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('profile');

    Route::prefix('twofactor')->group(function () {
        Route::get('/', [TwoFactorAuthController::class, 'manageTowFactor'])->name('profile.2fa.manage');
        Route::post('/', [TwoFactorAuthController::class, 'postManageTowFactor']);

        Route::get('/phone', [TokenAuthController::class, 'getPhoneVerify'])->name('profile.2fa.phone');
        Route::post('/phone', [TokenAuthController::class, 'postPhoneVerify']);
    });
});

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'single']);
Route::post('comments', [HomeController::class, 'comment'])->name('send.comment');
