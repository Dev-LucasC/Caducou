<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestAccountValidationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Valide sua conta no Caducou',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.test-account-validation',
            with: [
                'validationUrl' => 'https://caducou.test/validar-conta/exemplo',
            ],
        );
    }
}
