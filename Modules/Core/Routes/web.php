<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\Admin\AuthRulesController;

Route::middleware('web')
    ->prefix('admin')
    ->name('core.')
    ->group(function (): void {
        Route::group([
            'prefix' => 'platform-settings',
            'as' => 'platform.',
            'middleware' => 'admin',
        ], function (): void {
            Route::get('auth-rules', [AuthRulesController::class, 'index'])
                ->name('auth-rules.index');

        });
    });
