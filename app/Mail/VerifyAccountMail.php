<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyAccountMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Valide sua conta no Caducou',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.verify-account',
            with: [
                'verificationUrl' => URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(60),
                    [
                        'id' => $this->user->getKey(),
                        'hash' => sha1($this->user->getEmailForVerification()),
                    ],
                ),
            ],
        );
    }
}
