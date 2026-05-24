<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DebtsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Debts', [
            'summary' => [
                'openAmount' => 'R$ 48.720,00',
                'overdueAmount' => 'R$ 12.480,00',
                'partialAmount' => 'R$ 9.350,00',
                'draftCount' => 6,
            ],
            'debts' => [
                [
                    'id' => 'DIV-1048',
                    'debtor' => 'Rafael Lima',
                    'description' => 'Emprestimo pessoal',
                    'originalAmount' => 'R$ 8.200,00',
                    'currentAmount' => 'R$ 8.200,00',
                    'paidAmount' => 'R$ 0,00',
                    'originDate' => '12 abr 2026',
                    'dueDate' => 'Vencida ha 8 dias',
                    'status' => 'Vencida',
                    'tone' => 'risk',
                    'nextAction' => 'Revisar cobranca por e-mail',
                ],
                [
                    'id' => 'DIV-1039',
                    'debtor' => 'Marina Costa',
                    'description' => 'Parcelamento de servico',
                    'originalAmount' => 'R$ 5.400,00',
                    'currentAmount' => 'R$ 3.600,00',
                    'paidAmount' => 'R$ 1.800,00',
                    'originDate' => '02 mar 2026',
                    'dueDate' => '25 maio 2026',
                    'status' => 'Ativa',
                    'tone' => 'ok',
                    'nextAction' => 'Acompanhar link de pagamento',
                ],
                [
                    'id' => 'DIV-1027',
                    'debtor' => 'Studio Aurora',
                    'description' => 'Venda parcelada',
                    'originalAmount' => 'R$ 3.750,00',
                    'currentAmount' => 'R$ 1.750,00',
                    'paidAmount' => 'R$ 2.000,00',
                    'originDate' => '18 fev 2026',
                    'dueDate' => '31 maio 2026',
                    'status' => 'Parcialmente paga',
                    'tone' => 'warn',
                    'nextAction' => 'Confirmar proxima parcela',
                ],
                [
                    'id' => 'DIV-1018',
                    'debtor' => 'Bruno Martins',
                    'description' => 'Venda informal',
                    'originalAmount' => 'R$ 950,00',
                    'currentAmount' => 'R$ 950,00',
                    'paidAmount' => 'R$ 0,00',
                    'originDate' => '08 jan 2026',
                    'dueDate' => 'Sem vencimento',
                    'status' => 'Ativa',
                    'tone' => 'neutral',
                    'nextAction' => 'Definir vencimento antes de alertas',
                ],
            ],
            'statusBreakdown' => [
                ['label' => 'Ativas', 'value' => 42],
                ['label' => 'Vencidas', 'value' => 19],
                ['label' => 'Parciais', 'value' => 12],
                ['label' => 'Rascunhos', 'value' => 6],
            ],
        ]);
    }
}
