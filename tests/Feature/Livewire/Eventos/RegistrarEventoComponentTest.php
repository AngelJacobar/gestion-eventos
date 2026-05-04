<?php

namespace Tests\Feature\Livewire\Eventos;

use App\Livewire\Eventos\RegistrarEventoComponent;
use App\Models\Usuario;
use Database\Seeders\AccionSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RolesPermisosSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrarEventoComponentTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $seeder = new DatabaseSeeder();
        $seeder->call(AccionSeeder::class);
        $seeder->call(RolesPermisosSeeder::class);

        // Asignar permisos de eventos al rol administrador
        $role = Role::findByName('administrador');
        $role->givePermissionTo([
            'registrar-evento',
            'consultar-listado-eventos',
            'editar-evento',
            'eliminar-evento',
        ]);
    }

    private function usuarioConPermiso(string $permiso): Usuario
    {
        return Usuario::all()
            ->filter(fn($u) => $u->hasPermissionTo($permiso))
            ->first();
    }

    // ──────────────────────────────────────────
    //  CASO 1 — POSITIVO: el componente renderiza
    // ──────────────────────────────────────────

    #[Test]
    public function renders_successfully(): void
    {
        // Dado: un usuario con permiso de registrar-evento autenticado
        $user = $this->usuarioConPermiso('registrar-evento');
        $this->actingAs($user);

        // Cuando/Entonces: el componente responde 200
        Livewire::test(RegistrarEventoComponent::class)
            ->assertStatus(200);
    }

    // ──────────────────────────────────────────
    //  CASO 2 — POSITIVO: creación exitosa de evento
    // ──────────────────────────────────────────

    #[Test]
    public function crear_evento_exitosamente(): void
    {
        // Dado: un usuario con permiso de registrar-evento autenticado
        Toaster::fake();
        Toaster::assertNothingDispatched();

        $user = $this->usuarioConPermiso('registrar-evento');
        $this->actingAs($user);

        $fechaInicio = now()->addDay()->toDateString();
        $fechaFin    = now()->addDays(3)->toDateString();

        // Cuando: se abre el modal de creación y se envía el formulario con datos válidos
        Livewire::test(RegistrarEventoComponent::class)
            ->dispatch('abrir-modal-registrar-evento', null)
            ->set('form.nombre', 'Congreso Nacional de Tecnología')
            ->set('form.fecha_inicio', $fechaInicio)
            ->set('form.fecha_fin', $fechaFin)
            ->set('form.lugar', 'Centro de Convenciones CDMX')
            ->set('form.capacidad', 200)
            ->call('guardar')
            // Entonces: no hay errores de validación
            ->assertHasNoErrors([
                'form.nombre',
                'form.fecha_inicio',
                'form.fecha_fin',
                'form.lugar',
                'form.capacidad',
            ]);

        // Entonces: el registro existe en la base de datos
        $this->assertDatabaseHas('evento', [
            'nombre'       => 'Congreso Nacional de Tecnología',
            'fecha_inicio' => $fechaInicio,
            'fecha_fin'    => $fechaFin,
            'lugar'        => 'Centro de Convenciones CDMX',
            'capacidad'    => 200,
        ]);

        // Entonces: se muestra el toast de éxito
        Toaster::assertDispatched('eventos.registro.exito');
    }

    // ──────────────────────────────────────────
    //  CASO 3 — NEGATIVO: nombre requerido
    // ──────────────────────────────────────────

    #[Test]
    public function no_crea_evento_sin_nombre(): void
    {
        // Dado: un usuario autenticado con permiso de registrar-evento
        $user = $this->usuarioConPermiso('registrar-evento');
        $this->actingAs($user);

        // Cuando: se envía el formulario sin nombre
        Livewire::test(RegistrarEventoComponent::class)
            ->dispatch('abrir-modal-registrar-evento', null)
            ->set('form.nombre', '')
            ->set('form.fecha_inicio', now()->addDay()->toDateString())
            ->set('form.fecha_fin', now()->addDays(3)->toDateString())
            ->set('form.lugar', 'Auditorio Central')
            ->set('form.capacidad', 100)
            ->call('guardar')
            // Entonces: error de validación en el campo nombre (required)
            ->assertHasErrors(['form.nombre' => 'required']);

        // Entonces: no se guarda ningún evento
        $this->assertDatabaseMissing('evento', ['lugar' => 'Auditorio Central']);
    }

    // ──────────────────────────────────────────
    //  CASO 4 — NEGATIVO: fecha_inicio anterior a hoy
    // ──────────────────────────────────────────

    #[Test]
    public function no_crea_evento_con_fecha_inicio_anterior_a_hoy(): void
    {
        // Dado: un usuario autenticado con permiso de registrar-evento
        $user = $this->usuarioConPermiso('registrar-evento');
        $this->actingAs($user);

        // Cuando: se envía el formulario con fecha_inicio = ayer
        Livewire::test(RegistrarEventoComponent::class)
            ->dispatch('abrir-modal-registrar-evento', null)
            ->set('form.nombre', 'Evento Pasado')
            ->set('form.fecha_inicio', now()->subDay()->toDateString())
            ->set('form.fecha_fin', now()->addDay()->toDateString())
            ->set('form.lugar', 'Sala A')
            ->set('form.capacidad', 50)
            ->call('guardar')
            // Entonces: error de validación en fecha_inicio (after_or_equal:today)
            ->assertHasErrors(['form.fecha_inicio' => 'after_or_equal']);

        // Entonces: no se persiste el evento
        $this->assertDatabaseMissing('evento', ['nombre' => 'Evento Pasado']);
    }

    // ──────────────────────────────────────────
    //  CASO 5 — NEGATIVO: fecha_fin anterior a fecha_inicio
    // ──────────────────────────────────────────

    #[Test]
    public function no_crea_evento_con_fecha_fin_anterior_a_fecha_inicio(): void
    {
        // Dado: un usuario autenticado con permiso de registrar-evento
        $user = $this->usuarioConPermiso('registrar-evento');
        $this->actingAs($user);

        $fechaInicio = now()->addDays(5)->toDateString();
        $fechaFin    = now()->addDays(2)->toDateString(); // antes que inicio

        // Cuando: se envía el formulario con fecha_fin < fecha_inicio
        Livewire::test(RegistrarEventoComponent::class)
            ->dispatch('abrir-modal-registrar-evento', null)
            ->set('form.nombre', 'Evento con Fechas Invertidas')
            ->set('form.fecha_inicio', $fechaInicio)
            ->set('form.fecha_fin', $fechaFin)
            ->set('form.lugar', 'Sala B')
            ->set('form.capacidad', 80)
            ->call('guardar')
            // Entonces: error de validación en fecha_fin (after_or_equal:fecha_inicio)
            ->assertHasErrors(['form.fecha_fin' => 'after_or_equal']);

        // Entonces: no se persiste el evento
        $this->assertDatabaseMissing('evento', ['nombre' => 'Evento con Fechas Invertidas']);
    }

    

    // ──────────────────────────────────────────
    //  CASO 7 — NEGATIVO: registro duplicado
    // ───────────────────────────────────────// ──────────────────────────────────────────
    //  CASO 6 — NEGATIVO: capacidad menor a 1
    // ──────────────────────────────────────────

    #[Test]
    public function no_crea_evento_con_capacidad_invalida(): void
    {
        // Dado: un usuario autenticado con permiso de registrar-evento
        $user = $this->usuarioConPermiso('registrar-evento');
        $this->actingAs($user);

        // Cuando: se envía el formulario con capacidad = 0
        Livewire::test(RegistrarEventoComponent::class)
            ->dispatch('abrir-modal-registrar-evento', null)
            ->set('form.nombre', 'Evento Sin Capacidad')
            ->set('form.fecha_inicio', now()->addDay()->toDateString())
            ->set('form.fecha_fin', now()->addDays(2)->toDateString())
            ->set('form.lugar', 'Sala C')
            ->set('form.capacidad', 0)
            ->call('guardar')
            // Entonces: error de validación en capacidad (min:1)
            ->assertHasErrors(['form.capacidad' => 'min']);

        // Entonces: no se persiste el evento
        $this->assertDatabaseMissing('evento', ['nombre' => 'Evento Sin Capacidad']);
    }

    #[Test]
    public function no_crea_evento_duplicado(): void
    {
        // Dado: un usuario autenticado con permiso de registrar-evento
        $user = $this->usuarioConPermiso('registrar-evento');
        $this->actingAs($user);

        $fechaInicio = now()->addDay()->toDateString();
        $fechaFin    = now()->addDays(3)->toDateString();

        // Y: un evento ya registrado con los mismos datos
        Livewire::test(RegistrarEventoComponent::class)
            ->dispatch('abrir-modal-registrar-evento', null)
            ->set('form.nombre', 'Evento Duplicado')
            ->set('form.fecha_inicio', $fechaInicio)
            ->set('form.fecha_fin', $fechaFin)
            ->set('form.lugar', 'Auditorio Central')
            ->set('form.capacidad', 100)
            ->call('guardar')
            ->assertHasNoErrors();

        // Cuando: se intenta registrar el mismo evento nuevamente
        Livewire::test(RegistrarEventoComponent::class)
            ->dispatch('abrir-modal-registrar-evento', null)
            ->set('form.nombre', 'Evento Duplicado')
            ->set('form.fecha_inicio', $fechaInicio)
            ->set('form.fecha_fin', $fechaFin)
            ->set('form.lugar', 'Auditorio Central')
            ->set('form.capacidad', 100)
            ->call('guardar')
            // Entonces: error de validación por duplicado
            ->assertHasErrors(['form.nombre' => 'unique']);

        // Entonces: no se crea un nuevo registro en la base de datos
        $this->assertDatabaseCount('evento', 1);
    }





    // ──────────────────────────────────────────
    //  CASO 6 — NEGATIVO: capacidad menor a 0
    // ──────────────────────────────────────────

    #[Test]
    public function no_crea_evento_con_capacidad_invalida_menor_a_cero(): void
    {
        // Dado: un usuario autenticado con permiso de registrar-evento
        $user = $this->usuarioConPermiso('registrar-evento');
        $this->actingAs($user);

        // Cuando: se envía el formulario con capacidad = -5
        Livewire::test(RegistrarEventoComponent::class)
            ->dispatch('abrir-modal-registrar-evento', null)
            ->set('form.nombre', 'Evento Sin Capacidad')
            ->set('form.fecha_inicio', now()->addDay()->toDateString())
            ->set('form.fecha_fin', now()->addDays(2)->toDateString())
            ->set('form.lugar', 'Sala C')
            ->set('form.capacidad', -5)
            ->call('guardar')
            // Entonces: error de validación en capacidad (min:1)
            ->assertHasErrors(['form.capacidad' => 'min']);

        // Entonces: no se persiste el evento
        $this->assertDatabaseMissing('evento', ['nombre' => 'Evento Sin Capacidad']);
    }
}
