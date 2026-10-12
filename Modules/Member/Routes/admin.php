<?php

use Illuminate\Support\Facades\Route;
use Modules\Member\Http\Controllers\Admin\MemberController;

Route::controller(MemberController::class)->prefix('members')->name('members.')->group(function () {

    Route::get('/', 'index')->name('page');
    Route::post('/create', 'createMember')->name('create');
    Route::put('/{member}/edit', 'updateMember')->name('update');
    Route::put('/{member}/role', 'role')->name('role');
    Route::patch('/{member}/activate', 'activateMember')->name('activate');
    Route::put('/{member}/toggle', 'toggle')->name('block');
    Route::delete('/{member}/delete', 'destroy')->name('destroy');
});
