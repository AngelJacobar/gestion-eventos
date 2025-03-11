<?php

namespace Tests\Feature\Livewire\Usuarios;

use App\Enums\EstatusEnum;
use App\Livewire\Usuarios\CambiarEstatusUsuarioComponent;
use App\Models\Usuario;
use Database\Seeders\AccionSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RolesPermisosSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Tests\TestCase;

class CambiarEstatusUsuarioComponentTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        $seeder = new DatabaseSeeder();
        $this->artisan('migrate:fresh');
        $seeder->call(AccionSeeder::class);
        $seeder->call(RolesPermisosSeeder::class);
        Usuario::factory()->create([
            'nombre' => 'Prueba de Filtro',
            'primer_apellido' => 'Prueba de Filtro',
            'segundo_apellido' => 'Segundo Apellido assert',
            'email' => 'prueb.de.filtro@mail.com',
            'password' => bcrypt('password'),
            'activo' => EstatusEnum::Activo,
        ]);

        Usuario::factory()->create([
            'nombre' => 'Prueba de Filtro',
            'primer_apellido' => 'Prueba de Filtro2',
            'segundo_apellido' => 'Segundo Apellido assert2',
            'email' => 'prueb.de.filtro2@mail.com',
            'password' => bcrypt('password'),
            'activo' => EstatusEnum::Inactivo,
        ]);
    }

    /** @test */
    public function cambiar_estatus_correctamente()
    {
        Toaster::fake();
        Toaster::assertNothingDispatched();

        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('cambiar-estatus-usuario');
        })->first();

        $this->actingAs($user);

        $usuarioInactivo = Usuario::where('activo', EstatusEnum::Inactivo)->where('nombre', 'Prueba de Filtro')->first();
        $usuarioActivo = Usuario::where('activo', EstatusEnum::Activo)->where('nombre', 'Prueba de Filtro')->first();

        Livewire::test(CambiarEstatusUsuarioComponent::class)
            ->call('cambiarEstatusUsuario', $usuarioInactivo->id_usuario);

        $this->assertTrue($usuarioInactivo->fresh()->activo == EstatusEnum::Activo);
        Toaster::assertDispatched('usuarios.estatus.activacion');

        Livewire::test(CambiarEstatusUsuarioComponent::class)
            ->call('cambiarEstatusUsuario', $usuarioActivo->id_usuario);

        $this->assertTrue($usuarioActivo->fresh()->activo == EstatusEnum::Inactivo);
        Toaster::assertDispatched('usuarios.estatus.desactivacion');

        Livewire::test(CambiarEstatusUsuarioComponent::class)
            ->call('cambiarEstatusUsuario', $user->id_usuario);

        $this->assertTrue($usuarioActivo->fresh()->activo == EstatusEnum::Inactivo);
        Toaster::assertDispatched('usuarios.estatus.cierre_sesion');
    }

    /** @test */
    public function redirigir_al_login_si_no_se_esta_autenticado()
    {
        $this->get(route('admin.usuarios.index'))
            ->assertRedirect(route('login'));
    }
}
