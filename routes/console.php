<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestAccountValidationMail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('caducou:email-test {email}', function (string $email) {
    Mail::to($email)->send(new TestAccountValidationMail());

    $this->info("E-mail de teste enviado para {$email}.");
})->purpose('Send a Caducou test account validation email to Mailpit');
