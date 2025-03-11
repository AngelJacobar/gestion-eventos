<?php

namespace App\Livewire\Roles;

use App\Livewire\Forms\Roles\RegistrarRolForm;
use App\Traits\WithLiveValidation;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\Roles\Actions\RegistrarRolAction;
use Spatie\Permission\Models\Permission;

class RegistrarRolComponent extends Component
{
    use Toastable;
    use WithTrimArreglosRecursivos;
    use WithLiveValidation;

    public RegistrarRolForm $formRegistrarRol;

    public $modalAbierto = false;
    #[Locked]
    public $esEdicion = false;
    protected string $formName = 'formRegistrarRol';

    public function mount()
    {
        $this->authorize('registrar-rol');
    }

    public function updatedModalAbierto()
    {
        $this->restablecer();
    }

    public function render()
    {
        return view('livewire.roles.registrar-rol');
    }

    #[On('abrir-modal-asignar-permisos')]
    public function abrirModalAsignarPermisos($idRol = null)
    {
        $this->restablecer();
        $this->modalAbierto = true;
        $this->formRegistrarRol->setRole($idRol);

        $this->esEdicion = false;
        if ($this->formRegistrarRol->id_rol !== null) {
            $this->esEdicion = true;
        }
    }

    public function guardar()
    {
        $this->formRegistrarRol = $this->trimFormRecursivos($this->formRegistrarRol);
        $this->formRegistrarRol->validate();
        try {
            $this->authorize('registrar-rol');
            RegistrarRolAction::execute($this->formRegistrarRol, Auth::id());
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-roles');
            $mensaje = $this->esEdicion
                ? 'roles.edicion.exito'
                : 'roles.registro.exito';
            $this->success($mensaje);
            $this->esEdicion = false;
            $this->restablecer();
        } catch (AuthorizationException $e) {
            $this->error('messages.sin_permisos');
        } catch(\Exception $e) {
            $mensaje = $this->esEdicion
                ? 'roles.edicion.error'
                : 'roles.registro.error';
            $this->error($mensaje);
        }
    }

    #[Computed]
    public function permisos()
    {
        return Permission::all();
    }

    protected function restablecer()
    {
        $this->formRegistrarRol->reset();
        $this->resetValidation();
    }
}
