<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;

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
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('profile/twofactor', [ProfileController::class, 'manageTowFactor'])->name('profile.2fa.manage');
    Route::post('profile/twofactor', [ProfileController::class, 'postManageTowFactor']);

    Route::get('profile/twofactor/phone', [ProfileController::class, 'getPhoneVerify'])->name('profile.2fa.phone');
    Route::post('profile/twofactor/phone', [ProfileController::class, 'postPhoneVerify']);
});
