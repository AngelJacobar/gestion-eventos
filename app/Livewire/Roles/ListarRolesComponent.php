<?php

namespace App\Livewire\Roles;

use App\Livewire\Forms\Roles\BuscarRolesForm;
use App\Traits\WithColumnFiltering;
use App\Traits\WithColumnSorting;
use App\Traits\WithTrimArreglosRecursivos;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;
use Modulos\Roles\Actions\ListarRolesAction;
use Spatie\Permission\Models\Permission;

class ListarRolesComponent extends Component
{
    use Toastable;
    use WithPagination;
    use WithColumnSorting;
    use WithColumnFiltering;
    use WithTrimArreglosRecursivos;

    public BuscarRolesForm $buscarRol;
    public BuscarRolesForm $filtrosAplicados;

    protected $pageName = 'pagina';

    #[On('actualizar-lista-roles')]
    public function render()
    {
        return view('livewire.roles.listar-roles');
    }

    public function mount()
    {
        $this->restablecer();
    }

    public function restablecer()
    {
        $this->sort = 'id';
        $this->direction = 'asc';
        $this->cantidad = 10;
        $this->buscarRol->reset();
        $this->filtrosAplicados->reset();
        $this->actualizarMensajeFiltrado();
    }

    public function filtrar()
    {
        $this->resetPage();
        $this->buscarRol = $this->trimFormRecursivos($this->buscarRol);
        $this->filtrosAplicados = $this->buscarRol;
        $this->actualizarMensajeFiltrado();
    }

    #[Computed]
    public function roles()
    {
        try {
            $resultados = ListarRolesAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id', 'asc')
                ->paginate(perPage : $this->cantidad, pageName : $this->pageName);
        } catch (\Exception $e) {
            $this->error('messages.error_filtros');
            $this->filtrosAplicados->reset();
            $this->restablecer();
            $resultados = ListarRolesAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id', 'asc')
                ->paginate(perPage: $this->cantidad, pageName: $this->pageName);
        } finally {
            return $resultados;
        }
    }

    #[Computed]
    public function permisos()
    {
        return Permission::all();
    }
}
