<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Forgot Password (langsung ke reset)
    Route::get('/forgot-password', [ResetPasswordController::class, 'showForgotForm'])
        ->name('forgot-password');

    Route::post('/forgot-password', [ResetPasswordController::class, 'checkEmailAndRedirect'])
        ->name('forgot-password.post');

    // Reset Password
    Route::get('/reset-password/{email}', [ResetPasswordController::class, 'showResetForm'])
        ->name('reset-password');

    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
        ->name('reset-password.post');
});


Route::middleware('auth')->group(function () {
    // === Email Verification ===
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // === Confirm Password ===
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // === Update Password (Saat Login) ===
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // === Logout ===
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
