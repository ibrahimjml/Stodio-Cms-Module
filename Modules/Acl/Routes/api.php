<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('api/acl')
    ->name('api.acl.')
    ->group(function (): void {
        //
    });
