<?php

use Illuminate\Support\Facades\Route;
use Modules\Acl\Http\Controllers\Admin\PermissionController;
use Modules\Acl\Http\Controllers\Admin\RoleController;
use Modules\Acl\Http\Controllers\Admin\UserController;

Route::prefix('acl')->name('acl.')->group(function (): void {
    Route::patch('users/{user}/toggle-super', [UserController::class, 'toggleSuper'])->name('users.toggle-super');
    Route::resource('users', UserController::class)->except(['show', 'edit', 'update']);
    Route::get('users/profile/{user}', [UserController::class, 'edit'])->name('users.profile');
    Route::put('users/profile/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/profile/{user}/avatar', [UserController::class, 'destroyAvatar'])->name('users.avatar.destroy');
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});
