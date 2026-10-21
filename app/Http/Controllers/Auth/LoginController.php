<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        $email = Str::lower(trim($data['email']));
        $key = hash('sha256', $email.'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Muitas tentativas. Aguarde um minuto antes de tentar novamente.',
            ]);
        }

        if (! Auth::attempt(['email' => $email, 'password' => $data['password']], (bool) ($data['remember'] ?? false))) {
            RateLimiter::hit($key, 60);

            Log::notice('auth.login_failed');

            throw ValidationException::withMessages([
                'email' => 'Não foi possível entrar com essas credenciais.',
            ]);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        Log::info('auth.login_succeeded', ['user_id' => Auth::id()]);

        // Always start at a known internal route, never at a user-provided URL.
        $request->session()->forget('url.intended');

        if (! $request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->route('home');
    }
}
