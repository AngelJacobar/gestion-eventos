<?php

namespace App\Livewire\Eventos;

use Livewire\Component;
use App\Enums\EstatusEnum;
use App\Livewire\Forms\Eventos\RegistrarEventosForm;
use App\Traits\WithLiveValidation;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toastable;
use Modulos\GestionEventos\Evento\Actions\RegistrarEventosAction;
use Modulos\GestionEventos\Models\Evento;

class RegistrarEventoComponent extends Component
{
    use Toastable;
    use WithTrimArreglosRecursivos;
    use WithLiveValidation;

    public $idEvento;
    public $modalAbierto = false;
    public RegistrarEventosForm $form;
    protected $formName = 'form';

    public function render()
    {
        return view('livewire.eventos.registrar-evento-component');
    }

    #[On('abrir-modal-registrar-evento')]
    public function abrirModalRegistrarEvento($idEvento)
    {

        $this->idEvento = $idEvento;
        $this->form->reset();
        if ($idEvento) {
            $this->form->setDatos($idEvento);
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
            RegistrarEventosAction::execute($this->form, Auth::id(), $this->idEvento);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-eventos');
            $mensaje = $this->form->esEdicion ? 'eventos.edicion.exito' : 'eventos.registro.exito';
            $this->success($mensaje);
            $this->form->esEdicion = false;
            $this->restablecer();
        } catch (ValidationException $e) {
            $mensaje = $this->form->esEdicion ? 'eventos.edicion.error' : 'eventos.registro.error';
            $this->error($mensaje);
        }
    }

    protected function restablecer()
    {
        $this->form->reset();
        $this->idEvento = null;
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
