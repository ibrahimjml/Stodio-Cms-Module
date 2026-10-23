<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('twofactor')
    ->name('twofactor.')
    ->group(function (): void {
        //
    });
