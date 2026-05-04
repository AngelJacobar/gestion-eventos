<?php

namespace App\Livewire\Partidos;

use App\Livewire\Forms\Partidos\BuscarPartidosForm;
use App\Traits\WithColumnFiltering;
use App\Traits\WithColumnSorting;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Partidos\Actions\ListarPartidosAction;
use Livewire\Attributes\On;
use Modulos\Quinielas\Models\PartidosSemana;

class ListarPartidosComponent extends Component
{
    use Toastable;
    use WithPagination;
    use WithColumnSorting;
    use WithColumnFiltering;
    use WithTrimArreglosRecursivos;

    public BuscarPartidosForm $buscarPartido;
    public BuscarPartidosForm $filtrosAplicados;

    protected $pageName = 'pagina';

    
    public function render()
    {
        return view('livewire.partidos.listar-partidos-component');
    }

    public function mount()
    {
        $this->restablecer();
    }

    #[On('actualizar-lista-partidos')]
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
        $this->sort = 'id_partido';
        $this->direction = 'asc';
        $this->cantidad = 10;
        $this->buscarPartido->reset();
        $this->filtrosAplicados->reset();
        $this->actualizarMensajeFiltrado();
    }

    #[Computed]
    public function partidos()
    {
        $resultados = new Collection();
        try {
            $resultados = ListarPartidosAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id_partido', 'asc')
                ->paginate(perPage : $this->cantidad, pageName : $this->pageName);
        } catch (\Exception $e) {
            $this->error('messages.error_filtros');
            $this->filtrosAplicados->reset();
            $this->restablecer();
            $resultados = ListarPartidosAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id_partido', 'asc')
                ->paginate(perPage: $this->cantidad, pageName: $this->pageName);
        } finally {
            return $resultados;
        }
    }

    #[Computed]
    public function estatus()
    {
        return PartidosSemana::select('estatus')
            ->distinct()
            ->whereNotNull('estatus')
            ->get();
    }
}
