<?php

use App\Http\Controllers\EmployeeAuth\AuthenticatedSessionController;
use App\Http\Controllers\EmployeeAuth\ConfirmablePasswordController;
use App\Http\Controllers\EmployeeAuth\EmailVerificationNotificationController;
use App\Http\Controllers\EmployeeAuth\EmailVerificationPromptController;
use App\Http\Controllers\EmployeeAuth\NewPasswordController;
use App\Http\Controllers\EmployeeAuth\PasswordController;
use App\Http\Controllers\EmployeeAuth\PasswordResetLinkController;
use App\Http\Controllers\EmployeeAuth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:employee')->group(function () {

    Route::get('employee/login', [AuthenticatedSessionController::class, 'create'])
                ->name('employee.login');

    Route::post('employee/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('employee/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('employee.password.request');

    Route::post('employee/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('employee.password.email');

    Route::get('employee/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('employee.password.reset');

    Route::post('employee/reset-password', [NewPasswordController::class, 'store'])
                ->name('employee.password.store');
});

Route::middleware('auth:employee')->group(function () {
    Route::get('employee/verify-email', EmailVerificationPromptController::class)
                ->name('employee.verification.notice');

    Route::get('employee/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('employee.verification.verify');

    Route::post('employee/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('employee.verification.send');

    Route::get('employee/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('employee.password.confirm');

    Route::post('employee/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('employee/password', [PasswordController::class, 'update'])->name('employee.password.update');

    Route::post('employee/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('employee.logout');
});
