<?php

use Illuminate\Support\Facades\Route;
use Modules\Acl\Http\Controllers\Auth\LoginController;

Route::middleware('web')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::group(['middleware' => 'admin.guest'], function (): void {
            Route::get('login', [LoginController::class, 'login'])->name('login');
            Route::post('login', [LoginController::class, 'authenticate'])->name('login.post');
        });
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
