<?php

namespace App\Livewire\Sesiones;

use App\Livewire\Forms\Sesiones\BuscarSesionesForm;
use App\Traits\WithColumnFiltering;
use App\Traits\WithColumnSorting;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;
use Modulos\GestionEventos\Models\Evento;
use Modulos\GestionEventos\Sesiones\Actions\ListarSesionesAction;

class ListarSesionesComponent extends Component
{
    use Toastable;
    use WithPagination;
    use WithColumnSorting;
    use WithColumnFiltering;
    use WithTrimArreglosRecursivos;

    public BuscarSesionesForm $buscarSesion;
    public BuscarSesionesForm $filtrosAplicados;

    protected $pageName = 'pagina';

    
    public function render()
    {
        return view('livewire.sesiones.listar-sesiones-component');
    }

    public function mount()
    {
        $this->restablecer();
    }

    public function filtrar()
    {
        $this->resetPage();
        $this->buscarSesion = $this->trimFormRecursivos($this->buscarSesion);
        $this->buscarSesion->validate();

        $this->filtrosAplicados = $this->buscarSesion;
        $this->actualizarMensajeFiltrado();
    }

    public function limpiar()
    {
        $this->resetPage();
        $this->restablecer();
    }

    public function restablecer()
    {
        $this->sort = 'id_evento';
        $this->direction = 'asc';
        $this->cantidad = 10;
        $this->buscarSesion->reset();
        $this->filtrosAplicados->reset();
        $this->actualizarMensajeFiltrado();
    }

    #[On('actualizar-lista-sesiones')]
    public function actualizar()
    {
    }

    #[Computed]
    public function eventos()
    {
        return Evento::buscar()
            ->orderBy('nombre', 'asc')
            ->get();
    }

    #[Computed]
    public function sesiones()
    {
        $resultados = new Collection();
        try {
            $resultados = ListarSesionesAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id_sesion', 'asc')
                ->paginate(perPage : $this->cantidad, pageName : $this->pageName);
        } catch (\Exception $e) {
            $this->error('messages.error_filtros');
            $this->filtrosAplicados->reset();
            $this->restablecer();
            $resultados = ListarSesionesAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id_sesion', 'asc')
                ->paginate(perPage: $this->cantidad, pageName: $this->pageName);
        } finally {
            return $resultados;
        }
    }
}
