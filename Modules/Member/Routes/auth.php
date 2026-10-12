<?php 

use Illuminate\Support\Facades\Route;
use Modules\Member\Http\Controllers\Auth\LoginController;
use Modules\Member\Http\Controllers\Auth\RegisterController;



Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::middleware('member.guest')->group(function () {
            // Register and login routes
            Route::controller(RegisterController::class)->group(function () {
                Route::view('/register', 'member::auth.register')->name('register.index');
                Route::post('/register', 'register')->name('register.post');
            });
            Route::controller(LoginController::class)->group(function () {
                Route::view('/login', 'member::auth.login')->name('login.index');
                Route::post('/login', 'login')->name('login.post');
            });
            // forgot password routes
            // Route::controller(ForgotPassController::class)->group(function () {
            //   Route::view('/forgotpassword', 'auth.forgot')->name('forgot.password');
            //   Route::post('/forgotpassword', 'forgotpass')->name('forgot.password.post');
            //   Route::get('/reset/{token}', 'reset')->name('reset.password');
            //   Route::post('/reset/{token}', 'reset_pass')->name('reset.password.post');
            // });
        });

        Route::middleware('member')
            ->group(function () {

                Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
                // confirmation password
                // Route::view('/confirm-password', 'auth.confirmpassword')->name('password.confirm');
                // Route::post('/confirm-password', ConfirmPassController::class)->name('confirm.password');
                // email verification routes
                // Route::controller(EmailVerificationController::class)->group(function () {
                //   Route::get('/email/verify', 'verify_notice')->name('verification.notice');
                //   Route::get('/email/verify/{id}/{hash}', 'verify_email')->middleware('signed')->name('verification.verify');
                //   Route::post('/email/verification-notification', 'verify_notification')->middleware('throttle:6,1')->name('verification.send');
                // });
                // identity verification
                // Route::controller(IdentityVerificationController::class)->group(function () {
                //   Route::get('/verify-password-code', 'showVerification')->name('verify.code.show');
                //   Route::post('/verify-password-code', 'verifyCode')->name('verify.code');
                // });
            });
    });
