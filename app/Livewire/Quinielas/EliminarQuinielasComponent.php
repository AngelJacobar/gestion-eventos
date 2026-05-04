<?php

namespace App\Livewire\Quinielas;

use Livewire\Attributes\On;
use Livewire\Component;
use Modulos\Quinielas\Quinielas\Actions\EliminarQuinielasAction;
use Masmerise\Toaster\Toastable;

class EliminarQuinielasComponent extends Component
{
    public $idQuiniela;
    public $modalAbierto = false;

    use Toastable;

    public function render()
    {
        return view('livewire.quinielas.eliminar-quinielas-component');
    }

    #[On('abrir-modal-eliminar-quiniela')]
    public function abrirModal($idQuiniela)
    {
        $this->idQuiniela = $idQuiniela;
        $this->modalAbierto = true;
    }

    public function cancelar()
    {
        $this->modalAbierto = false;
    }

    public function eliminar()
    {
        try {
            EliminarQuinielasAction::execute($this->idQuiniela);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-quinielas');
            $this->success('quiniela.eliminacion.exito');
        }
        catch (\Exception $e) {            
            $this->error('quiniela.eliminacion.error');
        }
        
    }
}

