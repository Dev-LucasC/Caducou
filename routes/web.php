<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\EmprestimosController;



Route::get('/', function () {
    // Se o usuário estiver autenticado, redireciona para a página de início
    /** @var \Illuminate\Contracts\Auth\Guard $guard */
    $guard = auth();
    if ($guard->check()) {
        return redirect()->route('inicio');
    }

    // Se não estiver autenticado, mostra a página Welcome
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');



Route::get('/inicio', [PageController::class, 'inicio'])->name('inicio');


Route::prefix('dinheiroemprestado')->middleware('auth')->group(function () {
    Route::get('/', [EmprestimosController::class, 'index'])->name('emprestimos.index');
    Route::post('/', [EmprestimosController::class, 'store'])->name('emprestimos.store');
    Route::put('/{id}', [EmprestimosController::class, 'update'])->name('emprestimos.update');
    Route::delete('/{id}', [EmprestimosController::class, 'destroy'])->name('emprestimos.destroy');
});


Route::prefix('vendasrealizadas')->middleware('auth')->group(function () {
    Route::get('/', [VendasController::class, 'index'])->name('vendas.index');
    Route::post('/', [VendasController::class, 'store'])->name('vendas.store');
    Route::put('/{id}', [VendasController::class, 'update'])->name('vendas.update');
    Route::delete('/{id}', [VendasController::class, 'destroy'])->name('vendas.destroy');
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
