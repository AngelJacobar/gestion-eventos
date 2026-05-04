<?php

namespace App\Livewire\Partidos;

use Livewire\Component;
use App\Livewire\Forms\Partidos\RegistrarPartidosForm;
use App\Traits\WithLiveValidation;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Partidos\Actions\RegistrarPartidosAction;

class RegistrarPartidosComponent extends Component
{
    use Toastable;
    use WithTrimArreglosRecursivos;
    use WithLiveValidation;

    public $idPartido;
    public $modalAbierto = false;
    public RegistrarPartidosForm $form;
    protected $formName = 'form';

    public function render()
    {
        return view('livewire.partidos.registrar-partidos-component');
    }

    #[On('abrir-modal-registrar-partido')]
    public function abrirModalRegistrarPartido($idPartido)
    {

        $this->idPartido = $idPartido;
        $this->form->reset();
        if ($idPartido) {
            $this->form->setDatos($idPartido);
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
            RegistrarPartidosAction::execute($this->form, Auth::id(), $this->idPartido);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-partidos');
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
        $this->idPartido = null;
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
