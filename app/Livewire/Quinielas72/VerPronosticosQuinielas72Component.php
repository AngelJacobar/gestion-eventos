<?php

namespace App\Livewire\Quinielas72;

use Livewire\Component;
use Livewire\Attributes\On;
use Modulos\Quinielas\Models\Quinielas72;
use Modulos\Quinielas\Models\Partidos72;

class VerPronosticosQuinielas72Component extends Component
{
    public $modalAbierto = false;
    public $quiniela = null;
    public $pronosticos = [];

    public function render()
    {
        return view('livewire.quinielas72.ver-pronosticos-quinielas72-component');
    }

    #[On('abrir-modal-ver-pronosticos72')]
    public function abrirModal($idQuiniela72)
    {
        $this->quiniela = Quinielas72::with(['detalles.partido'])->findOrFail($idQuiniela72);
        
        // Organizar pronósticos por partido
        $this->pronosticos = [];
        foreach ($this->quiniela->detalles as $detalle) {
            $this->pronosticos[] = [
                'numero_partido' => $detalle->partido->numero_partido,
                'equipo_local' => $detalle->partido->equipo_local,
                'equipo_visitante' => $detalle->partido->equipo_visitante,
                'pronostico' => $detalle->pronostico,
                'resultado' => $detalle->partido->resultado,
                'acierto' => $detalle->acierto,
            ];
        }
        
        // Ordenar por número de partido
        usort($this->pronosticos, function($a, $b) {
            return $a['numero_partido'] <=> $b['numero_partido'];
        });
        
        $this->modalAbierto = true;
    }

    public function cerrar()
    {
        $this->modalAbierto = false;
        $this->reset(['quiniela', 'pronosticos']);
    }
}
