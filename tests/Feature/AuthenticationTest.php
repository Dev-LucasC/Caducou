<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_creditor_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create([
            'email' => 'credor@example.com',
            'password' => Hash::make('SenhaSegura123'),
        ]);

        $this->post('/login', [
            'email' => 'CREDOR@example.com',
            'password' => 'SenhaSegura123',
            'remember' => true,
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
        $this->get('/')->assertOk();

        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
        $this->get('/')->assertRedirect('/login');
    }

    public function test_unverified_creditor_can_log_in_but_cannot_view_internal_pages(): void
    {
        $user = User::factory()->unverified()->create([
            'password' => Hash::make('SenhaSegura123'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'SenhaSegura123',
        ])->assertRedirect('/email/confirmacao');

        $this->assertAuthenticatedAs($user);
        $this->get('/email/confirmacao')->assertOk();
        $this->get('/dividas')->assertRedirect('/email/confirmacao');
        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_invalid_credentials_never_authenticate_or_disclose_an_account(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('SenhaSegura123'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'Incorreta123',
        ])->assertSessionHasErrors('email');

        $this->post('/login', [
            'email' => 'naoexiste@example.com',
            'password' => 'Incorreta123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_multiple_failed_login_attempts_are_rate_limited(): void
    {
        $email = 'limit@example.com';
        $key = hash('sha256', $email.'|127.0.0.1');
        RateLimiter::clear($key);

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => $email, 'password' => 'Errada123'])
                ->assertSessionHasErrors('email');
        }

        $this->post('/login', ['email' => $email, 'password' => 'Errada123'])
            ->assertSessionHasErrors(['email' => 'Muitas tentativas. Aguarde um minuto antes de tentar novamente.']);

        $this->assertGuest();
        RateLimiter::clear($key);
    }

    public function test_guest_cannot_call_logout(): void
    {
        $this->post('/logout')->assertRedirect('/login');
    }
}
