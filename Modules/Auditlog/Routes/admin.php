<?php

use Illuminate\Support\Facades\Route;
use Modules\Auditlog\Http\Controllers\Admin\AuditLogController;

Route::prefix('auditlog')->name('auditlog.')->group(function () {
    // audit logs
    Route::controller(AuditLogController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/bulk-destroy', 'bulkDestroy')->name('bulk-destroy');
        Route::delete('/{auditLog}', 'destroy')->name('destroy');
    });
});
