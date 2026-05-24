<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SharedAuthDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_pages_share_sidebar_user_profile_data(): void
    {
        $user = User::factory()->create([
            'name' => 'Ana Credora',
            'email' => 'ana@gmail.com',
            'phone' => '11999999999',
            'account_type' => 'service_provider',
        ]);

        $this->actingAs($user)
            ->get('/')
            ->assertSuccessful()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->where('auth.user.name', 'Ana Credora')
                ->where('auth.user.email', 'ana@gmail.com')
                ->where('auth.user.phone', '11999999999')
                ->where('auth.user.accountType', 'Prestador de servico')
                ->where('auth.user.emailVerified', true)
            );
    }
}
