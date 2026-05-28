<?php

namespace App\Livewire\Quinielas72;

use App\Livewire\Forms\Quinielas72\RegistrarQuinielas72Form;
use App\Traits\WithLiveValidation;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Models\Partidos72;
use Modulos\Quinielas\Quinielas72\Actions\RegistrarQuinielas72Action;

class RegistrarQuinielas72Component extends Component
{
    use Toastable;
    use WithTrimArreglosRecursivos;
    use WithLiveValidation;

    public $idQuiniela72;
    public $modalAbierto = false;
    public RegistrarQuinielas72Form $form;
    protected $formName = 'form';

    public function render()
    {
        return view('livewire.quinielas72.registrar-quinielas72-component');
    }

    #[On('abrir-modal-registrar-quiniela72')]
    public function abrirModalRegistrarQuiniela72($idQuiniela72)
    {
        $this->idQuiniela72 = $idQuiniela72;
        $this->form->reset();
        
        if ($idQuiniela72) {
            $this->form->setDatos($idQuiniela72);
            $this->form->esEdicion = true;
        } else {
            $this->form->esEdicion = false;
            // Inicializar array de pronósticos vacío para los 72 partidos
            $partidos = Partidos72::orderBy('numero_partido', 'asc')->get();
            foreach ($partidos as $partido) {
                $this->form->pronosticos[$partido->id_partido_72] = null;
            }
        }

        $this->modalAbierto = true;
    }

    public function guardar()
    {
        $this->form = $this->trimFormRecursivos($this->form);
        
        // Asignar valores automáticos si no existen
        if (!$this->form->esEdicion) {
            $this->form->jornada = $this->form->jornada ?? 'Jornada 1';
            $this->form->fecha_registro = now()->format('Y-m-d');
            $this->form->puntaje_total = 0;
        }
        
        try {
            $this->form->validate();
        } catch (\Exception $e) {
            $this->error('messages.errores_formulario');
            throw $e;
        }

        try {
            RegistrarQuinielas72Action::execute($this->form, Auth::id(), $this->idQuiniela72);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-quinielas72');
            $mensaje = $this->form->esEdicion ? 'Quinielas.edicion.exito' : 'Quinielas.registro.exito';
            $this->success($mensaje);
            $this->form->esEdicion = false;
            $this->restablecer();
        } catch (ValidationException $e) {
            $mensaje = $this->form->esEdicion ? 'Quinielas.edicion.error' : 'Quinielas.registro.error';
            $this->error($mensaje);
        }
    }

    protected function restablecer()
    {
        $this->form->reset();
        $this->idQuiniela72 = null;
        $this->resetValidation();
    }

    public function liveValidation(string $campo): void
    {
        $this->validateOnly(
            'form.' . $campo,
            $this->form->rules()
        );
    }

    public function cancelar()
    {
        $this->modalAbierto = false;
    }

    #[Computed]
    public function partidos()
    {
        return Partidos72::orderBy('numero_partido', 'asc')->get();
    }
}
