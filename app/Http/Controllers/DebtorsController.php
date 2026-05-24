<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DebtorsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Debtors', [
            'summary' => [
                'totalDebtors' => 128,
                'activeDebtors' => 74,
                'overdueDebtors' => 19,
                'withPaymentPlan' => 12,
            ],
            'debtors' => [
                [
                    'name' => 'Marina Costa',
                    'initials' => 'MC',
                    'contact' => 'marina@exemplo.com',
                    'phone' => '(11) 90000-1200',
                    'openAmount' => 'R$ 3.600,00',
                    'debts' => 2,
                    'lastAction' => 'Link enviado ha 2 dias',
                    'status' => 'Ativo',
                    'tone' => 'ok',
                ],
                [
                    'name' => 'Rafael Lima',
                    'initials' => 'RL',
                    'contact' => 'rafael@exemplo.com',
                    'phone' => '(21) 90000-4500',
                    'openAmount' => 'R$ 8.200,00',
                    'debts' => 1,
                    'lastAction' => 'Cobranca pendente de revisao',
                    'status' => 'Vencido',
                    'tone' => 'risk',
                ],
                [
                    'name' => 'Studio Aurora',
                    'initials' => 'SA',
                    'contact' => 'financeiro@studioaurora.com',
                    'phone' => '(31) 90000-2200',
                    'openAmount' => 'R$ 1.750,00',
                    'debts' => 3,
                    'lastAction' => 'Pagamento parcial registrado',
                    'status' => 'Parcial',
                    'tone' => 'warn',
                ],
                [
                    'name' => 'Bruno Martins',
                    'initials' => 'BM',
                    'contact' => 'bruno@exemplo.com',
                    'phone' => 'Nao informado',
                    'openAmount' => 'R$ 950,00',
                    'debts' => 1,
                    'lastAction' => 'Sem cobranca recente',
                    'status' => 'Sem vencimento',
                    'tone' => 'neutral',
                ],
            ],
            'segments' => [
                ['label' => 'Pessoa fisica', 'value' => 96],
                ['label' => 'Negocio pequeno', 'value' => 24],
                ['label' => 'Prestador parceiro', 'value' => 8],
            ],
        ]);
    }
}
