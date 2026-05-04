<?php

namespace App\Livewire\Usuarios;

use App\Livewire\Forms\Usuarios\BuscarUsuariosForm;
use App\Traits\WithColumnFiltering;
use App\Traits\WithColumnSorting;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;
use Modulos\Usuarios\Actions\ListarUsuariosAction;
use Spatie\Permission\Models\Role;

class ListarUsuariosComponent extends Component
{
    use Toastable;
    use WithPagination;
    use WithColumnSorting;
    use WithColumnFiltering;
    use WithTrimArreglosRecursivos;

    public BuscarUsuariosForm $buscarUsuario;
    public BuscarUsuariosForm $filtrosAplicados;

    protected $pageName = 'pagina';

    #[On('actualizar-lista-usuarios')]
    public function render()
    {
        return view('livewire.usuarios.listar-usuarios');
    }

    public function mount()
    {
        $this->restablecer();
    }

    public function filtrar()
    {
        $this->resetPage();
        $this->buscarUsuario = $this->trimFormRecursivos($this->buscarUsuario);
        $this->buscarUsuario->validate();

        $this->filtrosAplicados = $this->buscarUsuario;
        $this->actualizarMensajeFiltrado();
    }

    public function limpiar()
    {
        $this->resetPage();
        $this->restablecer();
    }

    public function restablecer()
    {
        $this->sort = 'id_usuario';
        $this->direction = 'asc';
        $this->cantidad = 10;
        $this->buscarUsuario->reset();
        $this->filtrosAplicados->reset();
        $this->actualizarMensajeFiltrado();
    }

    #[Computed]
    public function usuarios()
    {
        $resultados = new Collection();
        try {
            $resultados = ListarUsuariosAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id_usuario', 'asc')
                ->paginate(perPage : $this->cantidad, pageName : $this->pageName);
        } catch (\Exception $e) {
            $this->error('messages.error_filtros');
            $this->filtrosAplicados->reset();
            $this->restablecer();
            $resultados = ListarUsuariosAction::execute($this->filtrosAplicados)
                ->orderBy($this->sort, $this->direction)
                ->orderBy('id_usuario', 'asc')
                ->paginate(perPage: $this->cantidad, pageName: $this->pageName);
        } finally {
            return $resultados;
        }
    }

    #[Computed]
    public function roles()
    {
        return Role::select('id', 'name')->orderBy('name', 'asc')->get();
    }
}
