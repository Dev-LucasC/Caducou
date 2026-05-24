<?php

namespace Tests\Feature;

use App\Mail\TestAccountValidationMail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailServerTest extends TestCase
{
    public function test_the_test_account_validation_email_can_be_sent(): void
    {
        Mail::fake();

        Artisan::call('caducou:email-test', [
            'email' => 'credor@example.test',
        ]);

        Mail::assertSent(TestAccountValidationMail::class, function (TestAccountValidationMail $mail) {
            return $mail->hasTo('credor@example.test');
        });
    }
}
