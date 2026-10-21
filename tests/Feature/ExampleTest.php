<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_financial_routes_redirect_guests_to_login(): void
    {
        foreach (['/', '/devedores', '/dividas', '/perfil'] as $path) {
            $this->get($path)->assertRedirect('/login');
        }
    }

    public function test_financial_routes_redirect_unverified_users_to_verification(): void
    {
        $user = User::factory()->unverified()->create();

        foreach (['/', '/devedores', '/dividas', '/perfil'] as $path) {
            $this->actingAs($user)->get($path)->assertRedirect('/email/confirmacao');
        }
    }

    public function test_verified_user_can_open_the_financial_routes(): void
    {
        $user = User::factory()->create();

        foreach (['/', '/devedores', '/dividas', '/perfil'] as $path) {
            $this->actingAs($user)->get($path)->assertOk();
        }
    }

    public function test_guest_auth_pages_are_available(): void
    {
        $this->get('/login')->assertOk();
        $this->get('/criar-conta')->assertOk();
        $this->get('/esqueci-senha')->assertOk();
        $this->get('/redefinir-senha/test-token?email=teste@example.com')->assertOk();
    }
}
