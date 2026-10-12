<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('auditlog')
    ->name('auditlog.')
    ->group(function (): void {
        //
    });
