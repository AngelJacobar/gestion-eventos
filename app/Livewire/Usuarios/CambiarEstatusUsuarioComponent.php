<?php

namespace App\Livewire\Usuarios;

use App\Enums\EstatusEnum;
use App\Models\Usuario;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\Usuarios\Actions\CambiarEstatusUsuarioAction;

class CambiarEstatusUsuarioComponent extends Component
{
    use Toastable;

    public $idUsuario;
    public $mensajeConfirmacion;
    public $modalEstatusAbierto = false;
    public $desactivacionPropia = false;

    public function render()
    {
        return view('livewire.usuarios.cambiar-estatus-usuario');
    }

    #[On('abrir-modal-cambiar-estatus-usuario')]
    public function mostrarModalCambioEstatus(Usuario $usuario)
    {
        $this->idUsuario = $usuario->id_usuario;
        $this->modalEstatusAbierto = true;
        $this->mensajeConfirmacion = 'usuarios.estatus.confirmar_desactivacion';

        $this->desactivacionPropia = false;
        if ($usuario->id_usuario === auth()->id()) {
            $this->desactivacionPropia = true;
            $this->mensajeConfirmacion = 'usuarios.estatus.confirmar_desactivacion_propia';
        }

        if ($usuario->activo !== EstatusEnum::Activo) {
            $this->mensajeConfirmacion = 'usuarios.estatus.confirmar_activacion';
        }
    }

    public function cambiarEstatusUsuario($idUsuario)
    {
        try {
            $this->authorize('cambiar-estatus-usuario');
            $usuario = CambiarEstatusUsuarioAction::execute($idUsuario, auth()->id());
            $this->dispatch('actualizar-lista-usuarios');

            if ($idUsuario === auth()->id()) {
                $this->warning('usuarios.estatus.cierre_sesion');
                $this->dispatch('logout-usuario');
            } elseif ($usuario->activo === EstatusEnum::Activo) {
                $this->success('usuarios.estatus.activacion');
            } else {
                $this->warning('usuarios.estatus.desactivacion');
            }

            $this->reset();
        } catch (AuthorizationException $e) {
            $this->error('messages.sin_permisos');
        } catch (\Exception $e) {
            $this->error('usuarios.estatus.error');
        }
    }
}
