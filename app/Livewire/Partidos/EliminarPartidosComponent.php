<?php

namespace App\Livewire\Partidos;

use Livewire\Attributes\On;
use Livewire\Component;
use Modulos\Quinielas\Partidos\Actions\EliminarPartidosAction;
use Masmerise\Toaster\Toastable;

class EliminarPartidosComponent extends Component
{
    public $idPartido;
    public $modalAbierto = false;

    use Toastable;

    public function render()
    {
        return view('livewire.partidos.eliminar-partidos-component');
    }

    #[On('abrir-modal-eliminar-partido')]
    public function abrirModal($idPartido)
    {
        $this->idPartido = $idPartido;
        $this->modalAbierto = true;
    }

    public function cancelar()
    {
        $this->modalAbierto = false;
    }

    public function eliminar()
    {
        try {
            EliminarPartidosAction::execute($this->idPartido);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-partidos');
            $this->success('partido.eliminacion.exito');
        }
        catch (\Exception $e) {            
            $this->error('partido.eliminacion.error');
        }
        
    }
}

