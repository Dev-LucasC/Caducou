<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'accountType' => $this->accountTypeLabel($user->account_type),
                    'emailVerified' => $user->hasVerifiedEmail(),
                ] : null,
            ],
        ];
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
