<?php

namespace Tests\Feature\Livewire\Usuarios;

use App\Livewire\Usuarios\RegistrarUsuarioComponent;
use App\Models\Usuario;
use Database\Seeders\AccionSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RolesPermisosSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Modulos\Usuarios\Notifications\UsuarioRegistradoNotification;
use Tests\TestCase;

class RegistrarUsuarioComponentTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $seeder = new DatabaseSeeder();
        $this->artisan('migrate:fresh');
        $seeder->call(AccionSeeder::class);
        $seeder->call(RolesPermisosSeeder::class);
    }
    /** @test */
    public function renders_successfully()
    {
        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('registrar-usuario');
        })->first();

        $this->actingAs($user);

        Livewire::test(RegistrarUsuarioComponent::class)
            ->assertStatus(200);
    }

    /** @test */
    public function registrar_un_usuario()
    {
        Toaster::fake();
        Toaster::assertNothingDispatched();

        Notification::fake();

        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('registrar-usuario');
        })->first();

        $this->actingAs($user);

        Livewire::test(RegistrarUsuarioComponent::class)
            ->set('formRegistrarUsuario.nombre', '   Nombre   ')
            ->set('formRegistrarUsuario.primer_apellido', '   Apellido   Paterno   ')
            ->set('formRegistrarUsuario.segundo_apellido', '   Apellido   Materno   ')
            ->set('formRegistrarUsuario.email', 'mail.test@mail.test.com')
            ->set('formRegistrarUsuario.rol', 'administrador')
            ->call('guardar')
            ->assertHasNoErrors(['formRegistrarUsuario.nombre', 'formRegistrarUsuario.primer_apellido', 'formRegistrarUsuario.segundo_apellido', 'formRegistrarUsuario.email',
                'formRegistrarUsuario.rol',
            ]);

        Toaster::assertDispatched('usuarios.registro.exito');

        $this->assertDatabaseHas('usuario', [
            'nombre' => 'NOMBRE',
            'primer_apellido' => 'APELLIDO PATERNO',
            'segundo_apellido' => 'APELLIDO MATERNO',
            'email' => 'mail.test@mail.test.com',
        ]);

        $user = Usuario::where('email', 'mail.test@mail.test.com')->first();
        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $user->id_usuario,
            'model_type' => 'App\Models\Usuario',
            'role_id' => 1,
        ]);

        Notification::assertSentTo(
            [$user],
            UsuarioRegistradoNotification::class
        );

        Notification::assertCount(2);
    }

    /** @test */
    public function editar_usuario()
    {
        Toaster::fake();
        Toaster::assertNothingDispatched();

        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('registrar-usuario');
        })->first();

        $this->actingAs($user);

        Livewire::test(RegistrarUsuarioComponent::class)
            ->dispatch('abrir-modal-registrar-usuario', Usuario::first()->id_usuario)
            ->set('formRegistrarUsuario.nombre', '    Nombre     Actualizado     ')
            ->set('formRegistrarUsuario.primer_apellido', '   Apellido   Paterno    Actualizado    ')
            ->set('formRegistrarUsuario.segundo_apellido', '   Apellido   Materno    Actualizado   ')
            ->set('formRegistrarUsuario.email', 'mail.actualizado@mail.com')
            ->set('formRegistrarUsuario.rol', 'administrador')
            ->call('guardar')
            ->assertHasNoErrors(['formRegistrarUsuario.nombre', 'formRegistrarUsuario.primer_apellido', 'formRegistrarUsuario.segundo_apellido', 'formRegistrarUsuario.email',
                'formRegistrarUsuario.rol',
            ]);

        Toaster::assertDispatched('usuarios.edicion.exito');

        $this->assertDatabaseHas('usuario', [
            'nombre' => 'NOMBRE ACTUALIZADO',
            'primer_apellido' => 'APELLIDO PATERNO ACTUALIZADO',
            'segundo_apellido' => 'APELLIDO MATERNO ACTUALIZADO',
            'email' => 'mail.actualizado@mail.com',
        ]);

        $user = Usuario::where('email', 'mail.actualizado@mail.com')->first();
        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $user->id_usuario,
            'model_type' => 'App\Models\Usuario',
            'role_id' => 1,
        ]);
    }

    /** @test */
    public function redirigir_al_login_si_no_se_esta_autenticado()
    {
        $this->get(route('admin.usuarios.index'))
            ->assertRedirect(route('login'));
    }
}
