<?php 

use Illuminate\Support\Facades\Route;
use Modules\TwoFactor\Http\Controllers\Admin\TwoFactorSettingController;
use Modules\TwoFactor\Http\Controllers\DownloadRecoveyController;
use Modules\TwoFactor\Http\Controllers\TwoFactorController;
use Modules\TwoFactor\Http\Controllers\TwoFactorQrCodeController;
use Modules\TwoFactor\Http\Controllers\TwoFactorSessionController;

Route::middleware('admin')->group(function() {
    // enable global two factor settings
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function(){
            Route::put('settings',[TwoFactorSettingController::class,'update'])->name('update');
        });
    Route::group(['prefix' => 'acl/users/profile', 'as' => 'profile.'], function(){
           // geenrate qr-code
           Route::get('qrcode',[TwoFactorQrCodeController::class, 'qrcode'])->name('qrcode');
           // enable / disable
           Route::post('enable',[TwoFactorController::class, 'enable'])->name('enable');
           Route::delete('disable',[TwoFactorController::class, 'disable'])->name('disable');
           // download recovery
           Route::get('recovery-download', DownloadRecoveyController::class)->name('recovery.download');
  });
});

Route::middleware('admin.guest')->group(function() {
  Route::get('challenge',[TwoFactorSessionController::class, 'challengePage'])->name('challenge.index');
  Route::post('challenge-check',[TwoFactorSessionController::class, 'check'])->name('challenge.check');
});    