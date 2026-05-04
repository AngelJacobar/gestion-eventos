<?php

namespace Tests\Feature\Auth;

use App\Enums\EstatusEnum;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/iniciar-sesion');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = Usuario::factory()->create();

        $response = $this->post('/iniciar-sesion', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = Usuario::factory()->create();

        $this->post('/iniciar-sesion', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_inactive_users_can_not_authenticate(): void
    {
        $user = Usuario::factory()->create();
        $user->update(['activo' => EstatusEnum::Inactivo]);

        $this->post('/iniciar-sesion', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = Usuario::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_rate_limiter_throttles_after_five_attempts(): void
    {
        $user = Usuario::factory()->create();

        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/iniciar-sesion', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
            $response->assertStatus(302);
        }

        $response = $this->post('/iniciar-sesion', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertInvalid([
            'email' => 'Demasiados intentos de acceso',
        ]);
    }
}
