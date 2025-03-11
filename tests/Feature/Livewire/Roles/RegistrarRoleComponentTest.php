<?php

namespace Tests\Feature\Livewire\Roles;

use App\Livewire\Roles\RegistrarRolComponent;
use App\Models\Usuario;
use Database\Seeders\AccionSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RolesPermisosSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrarRoleComponentTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $seeder = new DatabaseSeeder();
        $seeder->call(RolesPermisosSeeder::class);
        $seeder->call(AccionSeeder::class);
    }
    /** @test */
    public function renders_successfully()
    {
        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('registrar-rol');
        })->first();

        $this->actingAs($user);

        Livewire::test(RegistrarRolComponent::class)
            ->assertStatus(200);
    }
    /** @test */
    public function registrar_rol()
    {
        Toaster::fake();
        Toaster::assertNothingDispatched();

        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('registrar-rol');
        })->first();

        $this->actingAs($user);

        Livewire::test(RegistrarRolComponent::class)
            ->set('formRegistrarRol.nombre', 'rol-de-prueba-para-registro')
            ->set('formRegistrarRol.permisos', [1,2])
            ->call('guardar')
            ->assertHasNoErrors(['formRegistrarRol.nombre', 'formRegistrarRol.permisos']);

        Toaster::assertDispatched('roles.registro.exito');

        $this->assertDatabaseHas('roles', [
            'name' => 'rol-de-prueba-para-registro',
        ]);

        $rol = Role::where('name', 'rol-de-prueba-para-registro')->first();
        $permisos = DB::table('role_has_permissions')->where('role_id', $rol->id)->get();
        $this->assertEquals(2, count($permisos));
    }

    /** @test */
    public function editar_rol()
    {
        Toaster::fake();
        Toaster::assertNothingDispatched();

        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('registrar-rol');
        })->first();

        $this->actingAs($user);

        Livewire::test(RegistrarRolComponent::class)
            ->dispatch('abrir-modal-asignar-permisos', Role::first()->id)
            ->set('formRegistrarRol.nombre', 'NombreRolActualizado')
            ->set('formRegistrarRol.permisos', [1])
            ->call('guardar')
            ->assertHasNoErrors(['formRegistrarRol.nombre', 'formRegistrarRol.permisos']);

        Toaster::assertDispatched('roles.edicion.exito');

        $this->assertDatabaseHas('roles', [
            'name' => 'NombreRolActualizado',
        ]);

        $rol = Role::where('name', 'NombreRolActualizado')->first();
        $permisos = DB::table('role_has_permissions')->where('role_id', $rol->id)->get();
        $this->assertEquals(1, count($permisos));
    }

    /** @test */
    public function redirigir_al_login_si_no_se_esta_autenticado()
    {
        $this->get(route('admin.roles.index'))
            ->assertRedirect(route('login'));
    }
}
