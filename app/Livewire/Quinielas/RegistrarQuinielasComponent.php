<?php

namespace App\Livewire\Quinielas;

use App\Livewire\Forms\Quinielas\RegistrarQuinielasForm;
use App\Traits\WithLiveValidation;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Models\PartidosSemana;
use Modulos\Quinielas\Quinielas\Actions\RegistrarQuinielasAction;

class RegistrarQuinielasComponent extends Component
{
    use Toastable;
    use WithTrimArreglosRecursivos;
    use WithLiveValidation;

    public $idQuiniela;
    public $modalAbierto = false;
    public RegistrarQuinielasForm $form;
    protected $formName = 'form';

    public function render()
    {
        return view('livewire.quinielas.registrar-quinielas-component');
    }

    #[On('abrir-modal-registrar-quiniela')]
    public function abrirModalRegistrarQuiniela($idQuiniela)
    {

        $this->idQuiniela = $idQuiniela;
        $this->form->reset();
        if ($idQuiniela) {
            $this->form->setDatos($idQuiniela);
            $this->form->esEdicion = true;
        } else {
            $this->form->esEdicion = false;
        }


        $this->modalAbierto = true;
    }


    public function guardar()
    {
        $this->form = $this->trimFormRecursivos($this->form);
        
        // Asignar valores automáticos si no existen
        if (!$this->form->esEdicion) {
            // Obtener la jornada de los partidos activos
            $partidoActivo = PartidosSemana::where('estatus', 'S')->first();
            $this->form->jornada = $partidoActivo ? $partidoActivo->jornada : 'Jornada 1';
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
            RegistrarQuinielasAction::execute($this->form, Auth::id(), $this->idQuiniela);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-quinielas');
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
        $this->idQuiniela = null;
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
        return PartidosSemana::where('estatus', 'S')
            ->get();
    }
}
