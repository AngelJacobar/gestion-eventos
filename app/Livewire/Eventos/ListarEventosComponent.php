<?php

namespace App\Livewire\Eventos;

use App\Livewire\Forms\Eventos\BuscarEventosForm;
use App\Traits\WithColumnFiltering;
use App\Traits\WithColumnSorting;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;
use Modulos\GestionEventos\Evento\Actions\ListarEventosAction;
use Livewire\Attributes\On;



class ListarEventosComponent extends Component
{
    use Toastable;
    use WithPagination;
    use WithColumnSorting;
    use WithColumnFiltering;
    use WithTrimArreglosRecursivos;

    public BuscarEventosForm $buscarEvento;
    public BuscarEventosForm $filtrosAplicados;

    protected $pageName = 'pagina';

    
    public function render()
    {
        return view('livewire.eventos.listar-eventos-component');
    }

    public function mount()
    {
        $this->restablecer();
    }

    #[On('actualizar-lista-eventos')]
    public function actualizar()
    {
    }


    public function filtrar()
    {
        $this->resetPage();
        $this->buscarEvento = $this->trimFormRecursivos($this->buscarEvento);
        $this->buscarEvento->validate();

        $this->filtrosAplicados = $this->buscarEvento;
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
        $this->buscarEvento->reset();
        $this->filtrosAplicados->reset();
        $this->actualizarMensajeFiltrado();
    }

    #[Computed]
    public function eventos()
    {
        $resultados = new Collection();
        try {
            $resultados = ListarEventosAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id_evento', 'asc')
                ->paginate(perPage : $this->cantidad, pageName : $this->pageName);
        } catch (\Exception $e) {
            $this->error('messages.error_filtros');
            $this->filtrosAplicados->reset();
            $this->restablecer();
            $resultados = ListarEventosAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id_evento', 'asc')
                ->paginate(perPage: $this->cantidad, pageName: $this->pageName);
        } finally {
            return $resultados;
        }
    }
}
