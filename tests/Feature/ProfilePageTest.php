<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_authenticated_user_can_view_their_profile_page(): void
    {
        $user = User::factory()->create([
            'name' => 'Ana Credora',
            'email' => 'ana@gmail.com',
            'phone' => '11999999999',
            'account_type' => 'service_provider',
            'terms_accepted_at' => now(),
        ]);

        $this->actingAs($user)
            ->get('/perfil')
            ->assertSuccessful()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Profile')
                ->where('user.name', 'Ana Credora')
                ->where('user.email', 'ana@gmail.com')
                ->where('user.phone', '11999999999')
                ->where('user.accountType', 'Prestador de servico')
                ->where('user.emailVerified', true)
            );
    }

    public function test_guests_are_redirected_from_the_profile_page(): void
    {
        $this->get('/perfil')->assertRedirect('/login');
    }
}
