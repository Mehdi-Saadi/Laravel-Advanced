<?php

use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\User\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
});

Route::resource('users', 'App\Http\Controllers\Admin\UserController');
Route::get('/users/{user}/permissions', [PermissionController::class, 'create'])->name('users.permissions')->middleware('can:staff-user-permissions');
Route::post('/users/{user}/permissions', [PermissionController::class, 'store'])->name('users.permissions.store')->middleware('can:staff-user-permissions');
Route::resource('permissions', 'App\Http\Controllers\Admin\PermissionController');
Route::resource('roles', 'App\Http\Controllers\Admin\RoleController');
Route::resource('products', 'App\Http\Controllers\Admin\ProductController')->except('show');

Route::get('comments/unapproved', [CommentController::class, 'unapproved'])->name('comments.unapproved');
Route::resource('comments', 'App\Http\Controllers\Admin\CommentController')->only(['index', 'update', 'destroy']);
