<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\AsistenciaEvento\ListarAsistenciaEventoComponent;
use App\Livewire\Eventos\ListarEventosComponent;
use App\Livewire\Partidos\ListarPartidosComponent;
use App\Livewire\Quinielas\ListarQuinielasComponent;
use App\Livewire\Roles\ListarRolesComponent;
use App\Livewire\Sesiones\ListarSesionesComponent;
use App\Livewire\Usuarios\ListarUsuariosComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/partidos', ListarPartidosComponent::class)->name('admin.partidos.index');
    Route::get('/quinielas', ListarQuinielasComponent::class)->name('admin.quinielas.index');
    Route::get('/eventos', ListarEventosComponent::class)->name('admin.eventos.index');
    Route::get('/sesiones', ListarSesionesComponent::class)->name('admin.sesiones.index');
    Route::get('/asistencias-evento', ListarAsistenciaEventoComponent::class)->name('admin.asistencias-evento.index');

    Route::get('/usuarios', ListarUsuariosComponent::class)->name('admin.usuarios.index')->middleware('permission:consultar-listado-usuarios|registrar-usuario|cambiar-estatus-usuario');
    Route::get('/roles', ListarRolesComponent::class)->name('admin.roles.index')->middleware('permission:consultar-listado-roles|registrar-rol');
});

require __DIR__ . '/auth.php';


//Para manejar errores 404
Route::fallback(function () {
    return redirect()->route('dashboard')->error('messages.pagina_no_existe');
});
