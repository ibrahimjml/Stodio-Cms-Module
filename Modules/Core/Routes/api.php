<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('api/core')
    ->name('api.core.')
    ->group(function (): void {
        //
    });
