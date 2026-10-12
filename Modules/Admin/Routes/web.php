<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\Dashboard\DashboardController;

Route::middleware(['web'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {

        Route::middleware('admin')->group(function (): void {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('posts', [DashboardController::class, 'posts'])->name('posts');
        });

    });
