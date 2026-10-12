<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('api/member')
    ->name('api.member.')
    ->group(function (): void {
        //
    });
