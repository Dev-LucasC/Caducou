<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function inicio()
    {
        $user = Auth::user()->load(['emprestimos', 'vendas']);

        // Use as collections já carregadas (sem parênteses)
        $totalEmprestimos = $user->emprestimos->count();
        $totalVendas = $user->vendas->count();
        $valorTotalEmprestimos = $user->emprestimos->sum('valor');
        $valorTotalVendas = $user->vendas->sum('valor');

        return Inertia::render('PageInicio', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'totalEmprestimos' => $totalEmprestimos,
                'totalVendas' => $totalVendas,
                'valorTotalEmprestimos' => $valorTotalEmprestimos,
                'valorTotalVendas' => $valorTotalVendas,
            ],
        ]);
    }
}
