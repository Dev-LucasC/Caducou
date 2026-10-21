<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_known_and_unknown_emails_receive_the_same_public_response(): void
    {
        $user = User::factory()->create(['email' => 'ana@example.com']);
        Notification::fake();

        $message = 'Se o e-mail estiver cadastrado, enviaremos um link para redefinir a senha.';

        $this->post('/esqueci-senha', ['email' => $user->email])
            ->assertSessionHas('status', $message);

        $this->post('/esqueci-senha', ['email' => 'naoexiste@example.com'])
            ->assertSessionHas('status', $message);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_password_can_be_reset_using_a_valid_one_time_token(): void
    {
        $user = User::factory()->create([
            'email' => 'ana@example.com',
            'password' => Hash::make('SenhaAntiga123'),
        ]);

        $token = Password::broker()->createToken($user);
        $this->post('/redefinir-senha', [
            'email' => $user->email,
            'token' => $token,
            'password' => 'SenhaNova12345',
            'password_confirmation' => 'SenhaNova12345',
        ])->assertRedirect('/login');

        $this->assertTrue(Hash::check('SenhaNova12345', $user->fresh()->password));

        $this->post('/redefinir-senha', [
            'email' => $user->email,
            'token' => $token,
            'password' => 'SenhaOutra12345',
            'password_confirmation' => 'SenhaOutra12345',
        ])->assertSessionHasErrors('email');
    }

    public function test_invalid_token_and_weak_password_are_rejected(): void
    {
        $user = User::factory()->create();

        $this->post('/redefinir-senha', [
            'email' => $user->email,
            'token' => 'invalid-token',
            'password' => 'SenhaForte123',
            'password_confirmation' => 'SenhaForte123',
        ])->assertSessionHasErrors('email');

        $this->post('/redefinir-senha', [
            'email' => $user->email,
            'token' => 'invalid-token',
            'password' => 'fraca',
            'password_confirmation' => 'fraca',
        ])->assertSessionHasErrors('password');
    }

    public function test_expired_token_is_rejected(): void
    {
        $user = User::factory()->create();
        $token = Password::broker()->createToken($user);

        $this->travel(61)->minutes();

        $this->post('/redefinir-senha', [
            'email' => $user->email,
            'token' => $token,
            'password' => 'SenhaForte123',
            'password_confirmation' => 'SenhaForte123',
        ])->assertSessionHasErrors('email');
    }
}
