<?php

use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    ConfirmablePasswordController,
    EmailVerificationNotificationController,
    EmailVerificationPromptController,
    NewPasswordController,
    PasswordController,
    PasswordResetLinkController,
    RegisteredUserController,
    OtpVerificationController,
    VerifyEmailController
};
use Illuminate\Support\Facades\Route;

/*------------------------------------------
| Routes untuk Guest (Pengguna Tidak Login)
|------------------------------------------*/
Route::middleware('guest')->group(function () {
    // Registrasi
    Route::controller(RegisteredUserController::class)->group(function () {
        Route::get('register', 'create')->name('register');
        Route::post('register', 'store');
    });

    // Login
    Route::controller(AuthenticatedSessionController::class)->group(function () {
        Route::get('login', 'create')->name('login');
        Route::post('login', 'store');
    });

    // Reset Password
    Route::controller(PasswordResetLinkController::class)->group(function () {
        Route::get('forgot-password', 'create')->name('password.request');
        Route::post('forgot-password', 'store')->name('password.email');
    });

    Route::controller(NewPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'create')->name('password.reset');
        Route::post('reset-password', 'store')->name('password.store');
    });
});

/*------------------------------------------
| Routes untuk Authenticated User
|------------------------------------------*/
Route::middleware('auth')->group(function () {

    // Verifikasi OTP (Wajib setelah registrasi)
    Route::controller(OtpVerificationController::class)->group(function () {
        Route::get('verify-otp', 'showOtpForm')
            ->name('verification.otp'); 
            
        Route::post('verify-otp', 'verifyOtp')
            ->name('verification.verify');
            
        Route::post('resend-otp', 'resendOtp')
            ->name('verification.resend');
    });

    // Manajemen Password
    Route::controller(ConfirmablePasswordController::class)->group(function () {
        Route::get('confirm-password', 'show')
            ->name('password.confirm');
        Route::post('confirm-password', 'store');
    });

    Route::put('password', [PasswordController::class, 'update'])
            ->name('password.update');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
});