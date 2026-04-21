<?php

namespace App\Livewire\AsistenciaEvento;

use App\Livewire\Forms\AsistenciaEvento\BuscarAsistenciaEventosForm;
use App\Models\Usuario;
use App\Traits\WithColumnFiltering;
use App\Traits\WithColumnSorting;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;
use Modulos\GestionEventos\AsistenciaEvento\Actions\ListarAsistenciaEventosAction;
use Modulos\GestionEventos\Models\Evento;

class ListarAsistenciaEventoComponent extends Component
{
    use Toastable;
    use WithPagination;
    use WithColumnSorting;
    use WithColumnFiltering;
    use WithTrimArreglosRecursivos;

    public BuscarAsistenciaEventosForm $buscarAsistenciaEvento;
    public BuscarAsistenciaEventosForm $filtrosAplicados;

    protected $pageName = 'pagina';

    
    public function render()
    {
        return view('livewire.asistencia-evento.listar-asistencia-evento-component');
    }

     #[On('actualizar-lista-asistencia-eventos')]
    public function actualizar()
    {
    }


    public function mount()
    {
        $this->restablecer();
        $this->aplicarFiltroUsuario();
        $this->filtrosAplicados->id_usuario = $this->buscarAsistenciaEvento->id_usuario;
    }

    public function filtrar()
    {
        $this->resetPage();
        $this->buscarAsistenciaEvento = $this->trimFormRecursivos($this->buscarAsistenciaEvento);
        $this->buscarAsistenciaEvento->validate();

        $this->filtrosAplicados = $this->buscarAsistenciaEvento;
        $this->actualizarMensajeFiltrado();
    }

    public function limpiar()
    {
        $this->resetPage();
        $this->restablecer();
    }

    public function restablecer()
    {
        $this->sort = 'id_asistente_evento';
        $this->direction = 'asc';
        $this->cantidad = 10;
        $this->buscarAsistenciaEvento->reset();
        $this->filtrosAplicados->reset();
        $this->aplicarFiltroUsuario();
        $this->filtrosAplicados->id_usuario = $this->buscarAsistenciaEvento->id_usuario;
        $this->actualizarMensajeFiltrado();
    }

    private function aplicarFiltroUsuario(): void
    {
        $user = auth()->user();
        if (! $user->hasRole('administrador') && ! $user->hasRole('Organizador')) {
            $this->buscarAsistenciaEvento->id_usuario = (string) $user->id_usuario;
        }
    }

    #[Computed]
     public function eventos()
    {
        return Evento::buscar()
            ->orderBy('nombre', 'asc')
            ->get();
    }

    #[Computed]
     public function usuarios()
    {
        return Usuario::buscar()
            ->orderBy('nombre', 'asc')
            ->get();
    }

    #[Computed]
    public function asistencias()
    {
        $resultados = new Collection();
        try {
            $resultados = ListarAsistenciaEventosAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id_asistente_evento', 'asc')
                ->paginate(perPage : $this->cantidad, pageName : $this->pageName);
        } catch (\Exception $e) {
            $this->error('messages.error_filtros');
            $this->filtrosAplicados->reset();
            $this->restablecer();
            $resultados = ListarAsistenciaEventosAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id_evento', 'asc')
                ->paginate(perPage: $this->cantidad, pageName: $this->pageName);
        } finally {
            return $resultados;
        }
    }
}
