<?php

namespace App\Livewire\Eventos;

use Livewire\Attributes\On;
use Livewire\Component;
use Modulos\GestionEventos\Evento\Actions\EliminarEventoAction;
use Masmerise\Toaster\Toastable;

class EliminarEventoComponent extends Component
{
    public $idEvento;
    public $modalAbierto = false;

    use Toastable;

    public function render()
    {
        return view('livewire.eventos.eliminar-evento-component');
    }

    #[On('abrir-modal-eliminar-evento')]
    public function abrirModal($idEvento)
    {
        $this->idEvento = $idEvento;
        $this->modalAbierto = true;
    }

    public function cancelar()
    {
        $this->modalAbierto = false;
    }

    public function eliminar()
    {
        try {
            EliminarEventoAction::execute($this->idEvento);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-eventos');
            $this->success('evento.eliminacion.exito');
        }
        catch (\Exception $e) {            
            $this->error('evento.eliminacion.error');
        }
        
    }
}

