<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('api/auditlog')
    ->name('api.auditlog.')
    ->group(function (): void {
        //
    });
