<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class CaducouDashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', [
            'summary' => [
                'openAmount' => 'R$ 48.720,00',
                'overdueAmount' => 'R$ 12.480,00',
                'receivedThisMonth' => 'R$ 8.940,00',
                'recoveryRate' => '34%',
            ],
            'debts' => [
                [
                    'debtor' => 'Marina Costa',
                    'description' => 'Parcelamento de servico',
                    'amount' => 'R$ 5.400,00',
                    'paid' => 'R$ 1.800,00',
                    'due' => '25 maio',
                    'status' => 'Ativa',
                    'tone' => 'ok',
                ],
                [
                    'debtor' => 'Rafael Lima',
                    'description' => 'Emprestimo pessoal',
                    'amount' => 'R$ 8.200,00',
                    'paid' => 'R$ 0,00',
                    'due' => 'Vencida ha 8 dias',
                    'status' => 'Vencida',
                    'tone' => 'risk',
                ],
                [
                    'debtor' => 'Studio Aurora',
                    'description' => 'Venda parcelada',
                    'amount' => 'R$ 3.750,00',
                    'paid' => 'R$ 2.000,00',
                    'due' => '31 maio',
                    'status' => 'Parcial',
                    'tone' => 'warn',
                ],
            ],
            'timeline' => [
                ['title' => 'Cobranca por e-mail preparada', 'meta' => 'Rafael Lima · aguardando revisao'],
                ['title' => 'Pagamento parcial registrado', 'meta' => 'Studio Aurora · R$ 1.000,00'],
                ['title' => 'Link de pagamento criado', 'meta' => 'Marina Costa · expira em 7 dias'],
            ],
        ]);
    }
}
