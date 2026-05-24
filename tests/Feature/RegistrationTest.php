<?php

namespace Tests\Feature;

use App\Mail\VerifyAccountMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_creditor_user_can_create_an_account_and_receive_verification_email(): void
    {
        Mail::fake();

        $response = $this->post('/criar-conta', [
            'name' => 'Ana Credora',
            'email' => 'ana@gmail.com',
            'phone' => '11999999999',
            'account_type' => 'individual',
            'password' => 'SenhaForte123',
            'password_confirmation' => 'SenhaForte123',
            'terms_accepted' => true,
        ]);

        $response->assertRedirect('/email/confirmacao');

        $user = User::query()->where('email', 'ana@gmail.com')->firstOrFail();

        $this->assertAuthenticatedAs($user);
        $this->assertNull($user->email_verified_at);
        $this->assertTrue(Hash::check('SenhaForte123', $user->password));
        $this->assertSame('11999999999', $user->phone);
        $this->assertSame('individual', $user->account_type);
        $this->assertNotNull($user->terms_accepted_at);

        Mail::assertSent(VerifyAccountMail::class, function (VerifyAccountMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_registration_requires_valid_data_and_terms_acceptance(): void
    {
        Mail::fake();

        $response = $this->from('/criar-conta')->post('/criar-conta', [
            'name' => '',
            'email' => 'not-an-email',
            'phone' => str_repeat('9', 31),
            'account_type' => 'collector',
            'password' => 'fraca',
            'password_confirmation' => 'diferente',
            'terms_accepted' => false,
        ]);

        $response
            ->assertRedirect('/criar-conta')
            ->assertSessionHasErrors([
                'name',
                'email',
                'phone',
                'account_type',
                'password',
                'terms_accepted',
            ]);

        $this->assertDatabaseCount('users', 0);
        Mail::assertNothingSent();
    }

    public function test_the_signed_email_verification_link_verifies_and_logs_in_the_user(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'bruno@example.com',
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ],
        );

        $response = $this->get($verificationUrl);

        $response->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_the_verification_link_rejects_an_invalid_email_hash(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'carla@example.com',
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1('another-email@example.com'),
            ],
        );

        $this->get($verificationUrl)->assertForbidden();

        $this->assertGuest();
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    public function test_an_unverified_user_can_request_a_new_verification_email(): void
    {
        Mail::fake();

        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->post('/email/reenviar');

        $response
            ->assertRedirect()
            ->assertSessionHas('status', 'verification-link-sent');

        Mail::assertSent(VerifyAccountMail::class, function (VerifyAccountMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}
