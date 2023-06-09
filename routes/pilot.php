<?php

use App\Http\Controllers\Pilot\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Pilot\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Pilot\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Pilot\Auth\PilotEmailVerificationPromptController;
use App\Http\Controllers\Pilot\Auth\PilotNewPasswordController;
use App\Http\Controllers\Pilot\Auth\PasswordController;
use App\Http\Controllers\Pilot\Auth\PasswordResetLinkController;
use App\Http\Controllers\Pilot\Auth\RegisteredUserController;
use App\Http\Controllers\Pilot\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [PilotNewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [PilotNewPasswordController::class, 'store'])
        ->name('password.store');
});


//パイロットユーザーでの認証時に使われるルーティング
Route::middleware('auth:pilot')->group(function () {
    Route::get('verify-email', [PilotEmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
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
