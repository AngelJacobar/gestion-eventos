<?php

namespace Tests\Feature\Livewire\Roles;

use App\Livewire\Forms\Roles\BuscarRolesForm;
use App\Livewire\Roles\ListarRolesComponent;
use App\Models\Usuario;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RolesPermisosSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ListarRolesComponentTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $seeder = new DatabaseSeeder();
        $seeder->call(RolesPermisosSeeder::class);

        Role::create(['name' => 'rol-para-pruebas']);
    }

    /** @test */
    public function renders_successfully()
    {
        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('consultar-listado-roles');
        })->first();

        $this->actingAs($user);

        Livewire::test(ListarRolesComponent::class)
            ->assertSee('Roles')
            ->assertSee('Agregar nuevo rol')
            ->assertStatus(200);
    }

    /** @test */
    public function filtrar_correctamente()
    {
        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('consultar-listado-roles');
        })->first();

        $this->actingAs($user);
        $buscarRol = new BuscarRolesForm(new ListarRolesComponent(), '');
        $buscarRol->fill(['nombre' => 'rol-para-pruebas']);
        Livewire::test(ListarRolesComponent::class)
            ->set('buscarRol', $buscarRol)
            ->call('filtrar')
            ->assertSee('rol-para-pruebas');
    }

    /** @test */
    public function redirigir_al_login_si_no_se_esta_autenticado()
    {
        $this->get(route('admin.roles.index'))
            ->assertRedirect(route('login'));
    }
}
