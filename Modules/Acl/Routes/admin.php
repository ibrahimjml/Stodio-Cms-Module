<?php

use Illuminate\Support\Facades\Route;
use Modules\Acl\Http\Controllers\Admin\PermissionController;
use Modules\Acl\Http\Controllers\Admin\RoleController;
use Modules\Acl\Http\Controllers\Admin\UserController;

Route::prefix('acl')->name('acl.')->group(function (): void {
    Route::patch('users/{user}/toggle-super', [UserController::class, 'toggleSuper'])->name('users.toggle-super');
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});
