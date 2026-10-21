<?php

use App\Http\Controllers\CaducouDashboardController;
use App\Http\Controllers\DebtorsController;
use App\Http\Controllers\DebtsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\EmailVerificationNoticeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResendVerificationEmailController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', LoginController::class)->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1')->name('login.store');
    Route::get('/criar-conta', RegisterController::class)->name('register');
    Route::post('/criar-conta', [RegisterController::class, 'store'])->middleware('throttle:6,1')->name('register.store');
    Route::get('/esqueci-senha', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/esqueci-senha', [ForgotPasswordController::class, 'store'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/redefinir-senha/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/redefinir-senha', [ResetPasswordController::class, 'store'])->middleware('throttle:5,1')->name('password.update');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/email/confirmacao', EmailVerificationNoticeController::class)->name('verification.notice');
    Route::post('/email/reenviar', ResendVerificationEmailController::class)->middleware('throttle:3,1')->name('verification.send');
    Route::post('/logout', LogoutController::class)->name('logout');
});

// Signed email links must remain usable on a fresh browser without an active session.
Route::get('/email/verificar/{id}/{hash}', VerifyEmailController::class)->middleware('signed')->name('verification.verify');

Route::middleware(['auth', 'verified', 'auth.session'])->group(function (): void {
    Route::get('/', CaducouDashboardController::class)->name('home');
    Route::get('/devedores', DebtorsController::class)->name('debtors.index');
    Route::get('/dividas', DebtsController::class)->name('debts.index');
    Route::get('/perfil', ProfileController::class)->name('profile.show');
});
