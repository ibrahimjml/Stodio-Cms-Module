<?php

use Illuminate\Support\Facades\Route;
use Modules\ModuleManagement\Http\Controllers\Modules\ModulesController;

Route::middleware(['web'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {

        Route::middleware('admin')->group(function (): void {
            if (config('modulemanagement.config.enabled_modules_manager')) {

                Route::get('modules', [ModulesController::class, 'index'])->name('modules.index');

                Route::post('modules/{module}/migrate', [ModulesController::class, 'migrate'])->name('modules.migrate');

                Route::post('modules/{module}/activate', [ModulesController::class, 'activate'])->name('modules.activate');
                Route::post('modules/{module}/deactivate', [ModulesController::class, 'deactivate'])->name('modules.deactivate');

                Route::delete('modules/{module}', [ModulesController::class, 'destroy'])->name('modules.destroy');
            }
        });

    });
