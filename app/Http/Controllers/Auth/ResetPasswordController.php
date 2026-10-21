<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Inertia\Inertia;
use Inertia\Response;

class ResetPasswordController extends Controller
{
    public function create(Request $request, string $token): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', PasswordRule::min(10)->letters()->numbers()],
        ]);

        $status = Password::reset(
            ['email' => Str::lower(trim($data['email'])), 'token' => $data['token'], 'password' => $data['password'], 'password_confirmation' => $request->input('password_confirmation')],
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                Log::info('auth.password_reset_completed', ['user_id' => $user->getKey()]);
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withErrors(['email' => 'Link inválido ou expirado. Solicite uma nova redefinição.']);
        }

        return redirect()->route('login')->with('status', 'Senha atualizada. Entre com sua nova senha.');
    }
}
