<?php

use App\Http\Controllers\Admin\User\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
});

Route::resource('users', 'App\Http\Controllers\Admin\UserController');
Route::get('/users/{user}/permissions', [PermissionController::class, 'create'])->name('users.permissions');
Route::post('/users/{user}/permissions', [PermissionController::class, 'store'])->name('users.permissions.store');
Route::resource('permissions', 'App\Http\Controllers\Admin\PermissionController');
Route::resource('roles', 'App\Http\Controllers\Admin\RoleController');
