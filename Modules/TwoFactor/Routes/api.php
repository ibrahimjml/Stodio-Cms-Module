<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('api/twofactor')
    ->name('api.twofactor.')
    ->group(function (): void {
        //
    });
