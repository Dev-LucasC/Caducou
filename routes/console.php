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


// Read-only readiness check: never prints credentials or sends emails.
Artisan::command('caducou:infra-check', function () {
    $checks = [
        'Production mode (APP_DEBUG=false)' => config('app.debug') === false,
        'Application URL uses HTTPS' => str_starts_with((string) config('app.url'), 'https://'),
        'Persistent PostgreSQL connection configured' => config('database.default') === 'pgsql',
        'PostgreSQL SSL mode is require' => config('database.connections.pgsql.sslmode') === 'require',
        'Sessions persist in database' => config('session.driver') === 'database',
        'Session cookies require HTTPS' => config('session.secure') === true,
        'Shared database cache enabled' => config('cache.default') === 'database',
        'SMTP mailer enabled' => config('mail.default') === 'smtp',
        'SMTP credentials configured' => filled(config('mail.mailers.smtp.username')) && filled(config('mail.mailers.smtp.password')),
        'Verified sender configured' => filled(config('mail.from.address')),
    ];

    $failed = false;

    foreach ($checks as $name => $success) {
        $this->line(($success ? '[OK] ' : '[FAIL] ').$name);
        $failed = $failed || ! $success;
    }

    if (config('database.default') === 'pgsql') {
        try {
            \\Illuminate\\Support\\Facades\\DB::connection()->getPdo();

            $this->info('[OK] PostgreSQL connection established');

            foreach (['users', 'sessions', 'password_reset_tokens', 'cache', 'cache_locks'] as $table) {
                $exists = \\Illuminate\\Support\\Facades\\Schema::hasTable($table);
                $this->line(($exists ? '[OK] ' : '[FAIL] ').'Database table: '.$table);
                $failed = $failed || ! $exists;
            }
        } catch (\\Throwable $e) {
            // Do not expose connection strings, SQL or credentials from exception messages.
            $this->error('[FAIL] Could not connect to PostgreSQL. Check private configuration and provider status.');
            $failed = true;
        }
    }

    if ($failed) {
        $this->error('Preview infrastructure is not ready. No data was modified and no email was sent.');
        return 1;
    }

    $this->info('Preview infrastructure is ready for dedicated authentication smoke tests.');
    return 0;
})->purpose('Check PostgreSQL, persistent sessions/cache and mail readiness without modifying data');
