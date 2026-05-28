<?php

namespace App\Livewire\Partidos72;

use App\Livewire\Forms\Partidos72\BuscarPartidos72Form;
use App\Traits\WithColumnFiltering;
use App\Traits\WithColumnSorting;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Partidos72\Actions\ListarPartidos72Action;
use Livewire\Attributes\On;

class ListarPartidos72Component extends Component
{
    use Toastable;
    use WithPagination;
    use WithColumnSorting;
    use WithColumnFiltering;
    use WithTrimArreglosRecursivos;

    public BuscarPartidos72Form $buscarPartido;
    public BuscarPartidos72Form $filtrosAplicados;

    protected $pageName = 'pagina';

    public function render()
    {
        return view('livewire.partidos72.listar-partidos72-component');
    }

    public function mount()
    {
        $this->restablecer();
    }

    #[On('actualizar-lista-partidos72')]
    public function actualizar()
    {
    }

    public function filtrar()
    {
        $this->resetPage();
        $this->buscarPartido = $this->trimFormRecursivos($this->buscarPartido);
        $this->buscarPartido->validate();

        $this->filtrosAplicados = $this->buscarPartido;
        $this->actualizarMensajeFiltrado();
    }

    public function limpiar()
    {
        $this->resetPage();
        $this->restablecer();
    }

    public function restablecer()
    {
        $this->sort = 'numero_partido';
        $this->direction = 'asc';
        $this->cantidad = 20;
        $this->buscarPartido->reset();
        $this->filtrosAplicados->reset();
        $this->actualizarMensajeFiltrado();
    }

    #[Computed]
    public function partidos()
    {
        $resultados = new Collection();
        try {
            $resultados = ListarPartidos72Action::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('numero_partido', 'asc')
                ->paginate(perPage: $this->cantidad, pageName: $this->pageName);
        } catch (\Exception $e) {
            $this->error('messages.error_filtros');
            $this->filtrosAplicados->reset();
            $this->restablecer();
            $resultados = ListarPartidos72Action::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('numero_partido', 'asc')
                ->paginate(perPage: $this->cantidad, pageName: $this->pageName);
        } finally {
            return $resultados;
        }
    }
}
