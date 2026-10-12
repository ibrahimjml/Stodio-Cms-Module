<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->group(function (): void {
        require __DIR__.'/auth.php';
    });

