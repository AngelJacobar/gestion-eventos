<?php

namespace App\Livewire\Quinielas;

use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Models\PartidosSemana;
use Modulos\Quinielas\Quinielas\Actions\CalificarQuinielasAction;

class CalificarQuinielasComponent extends Component
{
    use Toastable;

    public $modalAbierto = false;

    public function render()
    {
        return view('livewire.quinielas.calificar-quinielas-component');
    }

    #[On('abrir-modal-calificar-quinielas')]
    public function abrirModal()
    {
        $this->modalAbierto = true;
    }

    public function cancelar()
    {
        $this->modalAbierto = false;
    }

    public function calificar()
    {
        try {
            // Verificar que todos los partidos tengan resultado
            $partidosSinResultado = PartidosSemana::where('estatus', 'S')
                ->whereNull('resultado')
                ->count();

            

            CalificarQuinielasAction::execute();
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-quinielas');
            $this->success('Las quinielas han sido calificadas exitosamente.');
        } catch (\Exception $e) {
            $this->error('Error al calificar las quinielas.');
        }
    }
}
