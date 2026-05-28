<?php

namespace App\Livewire\Quinielas72;

use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Models\Partidos72;
use Modulos\Quinielas\Quinielas72\Actions\CalificarQuinielas72Action;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class CalificarQuinielas72Component extends Component
{
    use Toastable;

    public $modalAbierto = false;

    public function render()
    {
        return view('livewire.quinielas72.calificar-quinielas72-component');
    }

    #[On('abrir-modal-calificar-quinielas72')]
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
            // Verificar que existan partidos sin resultado
            $partidosSinResultado = Partidos72::whereNull('resultado')->count();
            
            if ($partidosSinResultado > 0) {
                $this->warning("Atención: Hay {$partidosSinResultado} partidos sin resultado. Se calificarán solo los partidos con resultado.");
            }

            // Ejecutar la calificación
            CalificarQuinielas72Action::execute();
            
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-quinielas72');
            $this->success('Calificación completada exitosamente.');
            
            Log::info('Calificación de quinielas de 72 partidos completada');
        } catch (\Exception $e) {
            $this->error('Error al calificar las quinielas: ' . $e->getMessage());
            Log::error('Error al calificar quinielas de 72: ' . $e->getMessage());
        }
    }

    #[Computed]
    public function partidosSinResultado()
    {
        return Partidos72::whereNull('resultado')
            ->orderBy('numero_partido', 'asc')
            ->get();
    }

    #[Computed]
    public function partidosConResultado()
    {
        return Partidos72::whereNotNull('resultado')
            ->orderBy('numero_partido', 'asc')
            ->get();
    }
}
