<?php

namespace App\Livewire\AsistenciaEvento;

use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\GestionEventos\Models\AsistenteEvento;
use Modulos\GestionEventos\Models\Evento;


class GenerarConstanciaEventoComponent extends Component
{
    public $idAsistenciaEvento;
    public $modalAbierto = false;

    use Toastable;

    public function render()
    {
        return view('livewire.asistencia-evento.generar-constancia-evento-component');
    }

    #[On('abrir-modal-crear-constancia-evento')]
    public function abrirModal($idAsistenciaEvento)
    {
        $this->idAsistenciaEvento = $idAsistenciaEvento;
        $this->modalAbierto = true;
    }

    public function cancelar()
    {
        $this->modalAbierto = false;
    }

    public function generarConstancia()
    {
        try {
            // Obtener datos del asistente con joins optimizados
            $datosAsistencia = AsistenteEvento::buscar()
                ->where('asistente_evento.id_asistente_evento', $this->idAsistenciaEvento)
                ->first();
                
            if (!$datosAsistencia) {
                $this->error('No se encontró el registro de asistencia.');
                return;
            }

            // Obtener datos completos del evento
            $evento = Evento::find($datosAsistencia->id_evento);
            
            if (!$evento) {
                $this->error('No se encontró el evento.');
                return;
            }

            $data = [
                'nombreUsuario' => trim("{$datosAsistencia->nombre_usuario} {$datosAsistencia->primer_apellido} {$datosAsistencia->segundo_apellido}"),
                'nombreEvento' => $evento->nombre,
                'fechaInicio' => $evento->fecha_inicio,
                'fechaFin' => $evento->fecha_fin,
                'lugar' => $evento->lugar
            ];
            
            $pdf = Pdf::loadView('pdf.constancia-evento', $data)
                ->setPaper('a5', 'portrait');

            $this->modalAbierto = false;

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'constancia-evento.pdf'
            );
        } catch (\Exception $e) {
            $this->error('Error al generar la constancia.');
        }
    }
}