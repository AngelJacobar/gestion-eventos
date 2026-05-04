<?php

namespace App\Livewire\AsistenciaEvento;

use App\Livewire\Forms\AsistenciaEvento\RegistrarAsistenciaEventosForm;
use App\Models\Usuario;
use App\Traits\WithLiveValidation;
use App\Traits\WithTrimArreglosRecursivos;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\GestionEventos\AsistenciaEvento\Actions\RegistrarAsistenciaEventosAction;
use Modulos\GestionEventos\Models\Evento;

class RegistrarAsistenciaEventoComponent extends Component
{
    use Toastable;
    use WithTrimArreglosRecursivos;
    use WithLiveValidation;

    public $idAsistenciaEvento;
    public $modalAbierto = false;
    public RegistrarAsistenciaEventosForm $form;
    protected $formName = 'form';

    public function render()
    {
        return view('livewire.asistencia-evento.registrar-asistencia-evento-component');
    }

    #[On('abrir-modal-registrar-asistencia-evento')]
    public function abrirModalRegistrarAsistenciaEvento($idAsistenciaEvento)
    {

        $this->idAsistenciaEvento = $idAsistenciaEvento;
        $this->form->reset();
        if ($idAsistenciaEvento) {
            $this->form->setDatos($idAsistenciaEvento);
            $this->form->esEdicion = true;
        } else {
            $this->form->esEdicion = false;
            $this->aplicarFiltroUsuario();
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
            RegistrarAsistenciaEventosAction::execute($this->form, Auth::id(), $this->idAsistenciaEvento);
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-asistencia-eventos');
            $mensaje = $this->form->esEdicion ? 'asistencia_eventos.edicion.exito' : 'asistencia_eventos.registro.exito';
            $this->success($mensaje);
            $this->form->esEdicion = false;
            $this->restablecer();
        } catch (ValidationException $e) {
            $mensaje = $this->form->esEdicion ? 'asistencia_eventos.edicion.error' : 'asistencia_eventos.registro.error';
            $this->error($mensaje);
        }
    }

    protected function restablecer()
    {
        $this->form->reset();
        $this->idAsistenciaEvento = null;
        $this->resetValidation();
    }

    #[Computed]
    public function eventos()
    {
        return Evento::buscar()
            ->orderBy('nombre', 'asc')
            ->get();
    }

    #[Computed]
     public function usuarios()
    {
        return Usuario::buscar()
            ->orderBy('nombre', 'asc')
            ->get();
    }

     private function aplicarFiltroUsuario(): void
    {
        $user = auth()->user();
        $this->form->fecha_registro = now()->toDateString();
        if (! $user->hasRole('administrador') && ! $user->hasRole('Organizador')) {
            $this->form->id_usuario = (string) $user->id_usuario;
        }
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
