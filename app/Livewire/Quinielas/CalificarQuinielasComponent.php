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
            $partidosSinResultado = PartidosSemana::whereNull('resultado')
                ->count();

            // Ejecutar la acción de calificación
            CalificarQuinielasAction::execute();
            
            $this->modalAbierto = false;
            
            // Esperar un momento antes de actualizar para asegurar que la DB está actualizada
            $this->dispatch('actualizar-lista-quinielas');
            
            // Contar cuántas quinielas fueron calificadas
            $quinielasCalificadas = \Modulos\Quinielas\Models\Quinielas::where('puntaje_total', '>', 0)
                ->count();
            
            $totalQuinielas = \Modulos\Quinielas\Models\Quinielas::count();
            
            $this->success("Las quinielas han sido calificadas exitosamente. ({$quinielasCalificadas}/{$totalQuinielas} con puntos)");
            
        } catch (\Exception $e) {
            $this->error('Error al calificar las quinielas: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error('Error al calificar quinielas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
