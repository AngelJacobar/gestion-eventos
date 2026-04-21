<?php

namespace App\Livewire\Sesiones;

use Livewire\Attributes\On;
use Livewire\Component;
use Modulos\GestionEventos\Sesiones\Actions\EliminarSesionAction;
use Masmerise\Toaster\Toastable;

class EliminarSesionComponent extends Component
{
    public $idSesion;
    public $modalAbierto = false;

    use Toastable;

    public function render()
    {
        return view('livewire.sesiones.eliminar-sesion-component');
    }

    #[On('abrir-modal-eliminar-sesion')]
    public function abrirModal($idSesion)
    {
        $this->idSesion = $idSesion;
        $this->modalAbierto = true;
    }

    public function cancelar()
    {
        $this->modalAbierto = false;
    }

    public function eliminar()
    {
        try {
            EliminarSesionAction::execute($this->idSesion);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-sesiones');
            $this->success('sesion.eliminacion.exito');
        }
        catch (\Exception $e) {            
            $this->error('sesion.eliminacion.error');
        }
        
    }
}

