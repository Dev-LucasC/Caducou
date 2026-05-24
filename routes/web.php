<?php

use App\Http\Controllers\CaducouDashboardController;
use App\Http\Controllers\DebtorsController;
use App\Http\Controllers\DebtsController;
use Illuminate\Support\Facades\Route;

Route::get('/', CaducouDashboardController::class)->name('home');
Route::get('/devedores', DebtorsController::class)->name('debtors.index');
Route::get('/dividas', DebtsController::class)->name('debts.index');
