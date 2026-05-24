<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Profile', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'accountType' => $this->accountTypeLabel($user->account_type),
                'emailVerified' => $user->hasVerifiedEmail(),
                'createdAt' => $user->created_at?->format('d/m/Y'),
                'termsAcceptedAt' => $user->terms_accepted_at?->format('d/m/Y'),
            ],
        ]);
    }

    private function accountTypeLabel(?string $accountType): string
    {
        return match ($accountType) {
            'small_business' => 'Pequeno negocio',
            'service_provider' => 'Prestador de servico',
            default => 'Pessoa fisica',
        };
    }
}
