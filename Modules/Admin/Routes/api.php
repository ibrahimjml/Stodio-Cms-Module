<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('api/admin')
    ->name('api.admin.')
    ->group(function (): void {
        //
    });
