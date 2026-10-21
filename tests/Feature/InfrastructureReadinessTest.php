<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class InfrastructureReadinessTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_schema_has_persistent_auth_and_cache_tables(): void
    {
        foreach (['users', 'sessions', 'password_reset_tokens', 'cache', 'cache_locks'] as $table) {
            $this->assertTrue(Schema::hasTable($table), 'Missing migration table: '.$table);
        }
    }

    public function test_readiness_command_fails_safely_in_non_production_test_environment(): void
    {
        $exitCode = Artisan::call('caducou:infra-check');
        $output = Artisan::output();

        $this->assertSame(1, $exitCode);
        $this->assertStringContainsString('Preview infrastructure is not ready', $output);
        $this->assertStringNotContainsString('DB_PASSWORD=', $output);
        $this->assertStringNotContainsString('MAIL_PASSWORD=', $output);
    }
}
