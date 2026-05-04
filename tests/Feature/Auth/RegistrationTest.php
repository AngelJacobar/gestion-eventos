<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/registro');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/registro', [
            'nombre' => 'Test User',
            'primer_apellido' => 'Test',
            'segundo_apellido' => 'User',
            'email' => 'test@example.com',
            'password' => 'PaSsWoRd+56',
            'password_confirmation' => 'PaSsWoRd+56',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
