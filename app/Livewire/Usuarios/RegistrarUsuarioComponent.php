<?php

namespace App\Livewire\Usuarios;

use App\Livewire\Forms\Usuarios\RegistrarUsuarioForm;
use App\Traits\WithLiveValidation;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\Usuarios\Actions\RegistrarUsuarioAction;
use Spatie\Permission\Models\Role;

class RegistrarUsuarioComponent extends Component
{
    use Toastable;
    use WithTrimArreglosRecursivos;
    use WithLiveValidation;

    public RegistrarUsuarioForm $formRegistrarUsuario;

    public $modalAbierto = false;
    #[Locked]
    public $esEdicion = false;
    protected string $formName = 'formRegistrarUsuario';

    public function mount()
    {
        $this->authorize('registrar-usuario');
    }

    public function updatedModalAbierto()
    {
        $this->restablecer();
    }

    public function render()
    {
        return view('livewire.usuarios.registrar-usuario');
    }

    #[On('abrir-modal-registrar-usuario')]
    public function abrirModalRegistrarUsuario($idUsuario = null)
    {
        $this->restablecer();
        $this->modalAbierto = true;
        $this->formRegistrarUsuario->setUsuario($idUsuario);

        $this->esEdicion = false;
        if ($this->formRegistrarUsuario->id_usuario !== null) {
            $this->esEdicion = true;
        }
    }

    public function guardar()
    {
        $this->formRegistrarUsuario = $this->trimFormRecursivos($this->formRegistrarUsuario);
        $this->formRegistrarUsuario->validate();
        try {
            $this->authorize('registrar-usuario');
            RegistrarUsuarioAction::execute($this->formRegistrarUsuario, Auth::id());
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-usuarios');
            $mensaje = $this->esEdicion
                ? 'usuarios.edicion.exito'
                : 'usuarios.registro.exito';
            $this->success($mensaje);
            $this->esEdicion = false;
            $this->restablecer();
        } catch (AuthorizationException $e) {
            $this->error('messages.sin_permisos');
        } catch(\Exception $e) {
            $mensaje = $this->esEdicion
                ? 'usuarios.edicion.error'
                : 'usuarios.registro.error';
            $this->error($mensaje);
        }
    }

    #[Computed]
    public function roles()
    {
        return Role::select('id', 'name')->orderBy('name', 'asc')->get();
    }

    protected function restablecer()
    {
        $this->formRegistrarUsuario->reset();
        $this->resetValidation();
    }
}
