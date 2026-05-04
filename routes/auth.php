<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\IDULogin;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('iniciar-sesion', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('iniciar-sesion', [AuthenticatedSessionController::class, 'store']);

    Route::get('recuperar-contrasena', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('recuperar-contrasena', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('restablecer-contrasena/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('restablecer-contrasena', [NewPasswordController::class, 'store'])
        ->name('password.store');

    if (config('app.user_registration')) {
        Route::get('registro', [RegisteredUserController::class, 'create'])
            ->name('register');

        Route::post('registro', [RegisteredUserController::class, 'store']);
    }

    if (config('services.idu.sso')) {
        Route::get('/idu', [IDULogin::class, 'index'])->name('idu');
        Route::get('/idu/login', [IDULogin::class, 'login'])->name('idu-login');
    }
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
