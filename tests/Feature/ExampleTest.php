<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_debtors_page_returns_a_successful_response(): void
    {
        $response = $this->get('/devedores');

        $response->assertStatus(200);
    }

    public function test_the_debts_page_returns_a_successful_response(): void
    {
        $response = $this->get('/dividas');

        $response->assertStatus(200);
    }

    public function test_the_login_page_returns_a_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_the_register_page_returns_a_successful_response(): void
    {
        $response = $this->get('/criar-conta');

        $response->assertStatus(200);
    }
}
