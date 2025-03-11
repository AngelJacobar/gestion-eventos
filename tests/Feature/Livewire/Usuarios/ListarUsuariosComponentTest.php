<?php

namespace Tests\Feature\Livewire\Usuarios;

use App\Enums\EstatusEnum;
use App\Livewire\Forms\Usuarios\BuscarUsuariosForm;
use App\Livewire\Usuarios\ListarUsuariosComponent;
use App\Models\Usuario;
use Database\Seeders\AccionSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RolesPermisosSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class ListarUsuariosComponentTest extends TestCase
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
    public function renders_successfully()
    {
        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('consultar-listado-usuarios');
        })->first();

        $this->actingAs($user);

        Livewire::test(ListarUsuariosComponent::class)
            ->assertSee('Usuarios')
            ->assertSee('Agregar nuevo usuario')
            ->assertStatus(200);
    }

    /** @test */
    public function filtrar_correctamente()
    {
        $users = Usuario::all();
        $user = $users->filter(function ($user) {
            return $user->hasPermissionTo('consultar-listado-usuarios');
        })->first();

        $this->actingAs($user);

        $buscarUsuario = new BuscarUsuariosForm(new ListarUsuariosComponent(), '');
        $buscarUsuario->fill(['nombre' => 'Prueba de Filtro']);
        Livewire::test(ListarUsuariosComponent::class)
            ->set('buscarUsuario', $buscarUsuario)
            ->call('filtrar')
            ->assertSee('Segundo Apellido assert');
    }

    /** @test */
    public function redirigir_al_login_si_no_se_esta_autenticado()
    {
        $this->get(route('admin.usuarios.index'))
            ->assertRedirect(route('login'));
    }
}
