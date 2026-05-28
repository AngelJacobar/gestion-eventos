<?php

namespace App\Livewire\Partidos72;

use Livewire\Component;
use App\Livewire\Forms\Partidos72\RegistrarPartidos72Form;
use App\Traits\WithLiveValidation;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Partidos72\Actions\RegistrarPartidos72Action;

class RegistrarPartidos72Component extends Component
{
    use Toastable;
    use WithTrimArreglosRecursivos;
    use WithLiveValidation;

    public $idPartido72;
    public $modalAbierto = false;
    public RegistrarPartidos72Form $form;
    protected $formName = 'form';

    public function render()
    {
        return view('livewire.partidos72.registrar-partidos72-component');
    }

    #[On('abrir-modal-registrar-partido72')]
    public function abrirModalRegistrarPartido72($idPartido72)
    {
        $this->idPartido72 = $idPartido72;
        $this->form->reset();
        if ($idPartido72) {
            $this->form->setDatos($idPartido72);
            $this->form->esEdicion = true;
        } else {
            $this->form->esEdicion = false;
        }

        $this->modalAbierto = true;
    }

    public function guardar()
    {
        $this->form = $this->trimFormRecursivos($this->form);
        try {
            $this->form->validate();
        } catch (\Exception $e) {
            $this->error('messages.errores_formulario');
            throw $e;
        }

        try {
            RegistrarPartidos72Action::execute($this->form, Auth::id(), $this->idPartido72);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-partidos72');
            $mensaje = $this->form->esEdicion ? 'partidos.edicion.exito' : 'partidos.registro.exito';
            $this->success($mensaje);
            $this->form->esEdicion = false;
            $this->restablecer();
        } catch (ValidationException $e) {
            $mensaje = $this->form->esEdicion ? 'partidos.edicion.error' : 'partidos.registro.error';
            $this->error($mensaje);
        }
    }

    protected function restablecer()
    {
        $this->form->reset();
        $this->idPartido72 = null;
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
}
