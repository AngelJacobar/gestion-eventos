<?php

namespace App\Livewire\Sesiones;


use App\Livewire\Forms\Sesiones\RegistrarSesionesForm;
use App\Traits\WithLiveValidation;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\GestionEventos\Models\Evento;
use Modulos\GestionEventos\Sesiones\Actions\RegistrarSesionesAction;

class RegistrarSesionComponent extends Component
{
    use Toastable;
    use WithTrimArreglosRecursivos;
    use WithLiveValidation;

    public $idSesion;
    public $modalAbierto = false;
    public RegistrarSesionesForm $form;
    protected $formName = 'form';

     public function render()
    {
        return view('livewire.sesiones.registrar-sesion-component');
    }

    #[On('abrir-modal-registrar-sesion')]
    public function abrirModalRegistrarSesion($idSesion)
    {

        $this->idSesion = $idSesion;
        $this->form->reset();
        if ($idSesion) {
            $this->form->setDatos($idSesion);
            $this->form->esEdicion = true;
        } else {
            $this->form->esEdicion = false;
        }


        $this->modalAbierto = true;
    }

      #[Computed]
    public function eventos()
    {
        return Evento::buscar()
            ->orderBy('nombre', 'asc')
            ->get();
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
            RegistrarSesionesAction::execute($this->form, Auth::id(), $this->idSesion);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-sesiones');
            $mensaje = $this->form->esEdicion ? 'sesiones.edicion.exito' : 'sesiones.registro.exito';
            $this->success($mensaje);
            $this->form->esEdicion = false;
            $this->restablecer();
        } catch (ValidationException $e) {
            $mensaje = $this->form->esEdicion ? 'sesiones.edicion.error' : 'sesiones.registro.error';
            $this->error($mensaje);
        }
    }

    protected function restablecer()
    {
        $this->form->reset();
        $this->idSesion = null;
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
