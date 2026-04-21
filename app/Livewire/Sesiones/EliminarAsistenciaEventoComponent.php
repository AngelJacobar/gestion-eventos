<?php

namespace App\Livewire\AsistenciaEvento;

use Livewire\Attributes\On;
use Livewire\Component;
use Modulos\GestionEventos\AsistenciaEvento\Actions\EliminarAsistenciaEventosAction;
use Masmerise\Toaster\Toastable;

class EliminarAsistenciaEventoComponent extends Component
{
    public $idAsistenciaEvento;
    public $modalAbierto = false;

    use Toastable;

    public function render()
    {
        return view('livewire.asistencia-evento.eliminar-asistencia-evento-component');
    }

    #[On('abrir-modal-eliminar-asistencia-evento')]
    public function abrirModal($idAsistenciaEvento)
    {
        $this->idAsistenciaEvento = $idAsistenciaEvento;
        $this->modalAbierto = true;
    }

    public function cancelar()
    {
        $this->modalAbierto = false;
    }

    public function eliminar()
    {
        try {
            EliminarAsistenciaEventosAction::execute($this->idAsistenciaEvento);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-asistencia-eventos');
            $this->success('asistencia-evento.eliminacion.exito');
        }
        catch (\Exception $e) {            
            $this->error('asistencia-evento.eliminacion.error');
        }
        
    }
}

