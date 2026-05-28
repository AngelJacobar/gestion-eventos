<?php

namespace App\Livewire\Quinielas72;

use App\Enums\AccionEnum;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Models\Quinielas72;
use Modulos\Quinielas\Quinielas72\Actions\EliminarQuinielas72Action;

class EliminarQuinielas72Component extends Component
{
    use Toastable;

    public $idQuiniela72;
    public $modalAbierto = false;
    public $nombreQuiniela;

    public function render()
    {
        return view('livewire.quinielas72.eliminar-quinielas72-component');
    }

    #[On('abrir-modal-eliminar-quiniela72')]
    public function abrirModalEliminar($idQuiniela72)
    {
        $quiniela = Quinielas72::find($idQuiniela72);
        if ($quiniela) {
            $this->idQuiniela72 = $idQuiniela72;
            $this->nombreQuiniela = $quiniela->nombre;
            $this->modalAbierto = true;
        } else {
            $this->error('Quiniela no encontrada.');
        }
    }

    public function eliminar()
    {
        try {
            EliminarQuinielas72Action::execute($this->idQuiniela72, Auth::id());
            $this->modalAbierto = false;
            $this->dispatch('actualizar-lista-quinielas72');
            $this->success('Quiniela eliminada exitosamente.');
        } catch (\Exception $e) {
            $this->error('Error al eliminar la quiniela: ' . $e->getMessage());
        }
    }

    public function cancelar()
    {
        $this->modalAbierto = false;
        $this->reset(['idQuiniela72', 'nombreQuiniela']);
    }
}
