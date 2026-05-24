<?php

use App\Http\Controllers\CaducouDashboardController;
use App\Http\Controllers\DebtorsController;
use App\Http\Controllers\DebtsController;
use App\Http\Controllers\Auth\EmailVerificationNoticeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResendVerificationEmailController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::get('/', CaducouDashboardController::class)->name('home');
Route::get('/devedores', DebtorsController::class)->name('debtors.index');
Route::get('/dividas', DebtsController::class)->name('debts.index');
Route::get('/login', LoginController::class)->name('login');
Route::get('/criar-conta', RegisterController::class)->name('register');
Route::post('/criar-conta', [RegisterController::class, 'store'])->middleware('throttle:6,1')->name('register.store');
Route::get('/email/confirmacao', EmailVerificationNoticeController::class)->middleware('auth')->name('verification.notice');
Route::post('/email/reenviar', ResendVerificationEmailController::class)->middleware(['auth', 'throttle:3,1'])->name('verification.send');
Route::get('/email/verificar/{id}/{hash}', VerifyEmailController::class)->middleware('signed')->name('verification.verify');
