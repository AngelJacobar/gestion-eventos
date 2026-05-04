<?php

namespace App\Livewire\Forms\Eventos;

use App\Traits\ArreglosMultidimensionalesHelper;
use Livewire\Form;
use Modulos\GestionEventos\Models\Evento;

class RegistrarEventosForm extends Form
{
    use ArreglosMultidimensionalesHelper;

    public $id_evento;
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;
    public $lugar;
    public $capacidad;
    public $esEdicion;
   public function validationAttributes()
    {
        return [
            'nombre' => 'Nombre',
            'fecha_inicio' => 'Fecha de inicio',
            'fecha_fin' => 'Fecha de fin',
            'lugar' => 'Lugar',
            'capacidad' => 'Capacidad',
        ];
    }

    
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date', 'after_or_equal:today'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
            'lugar' => ['required', 'string', 'max:255'],
            'capacidad' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            "fecha_inicio.after_or_equal" => "El campo :atribute no puede ser anterior al día de hoy.",
            "fecha_fin.after_or_equal" => "El campo :atribute no puede ser menor a la fecha de inicio.", 
        ];
    }

    public function setDatos(?int $idEvento = null)
    {
        $this->id_evento = $idEvento;

        $evento = $idEvento
        ? Evento::findOrFail($idEvento)
        : new Evento();
        $this->esEdicion = false;

        if ($idEvento) {
        $this->esEdicion = true;
        $this->id_evento = $evento->id_evento;
        $this->nombre = $evento->nombre;
        $this->fecha_inicio = $evento->fecha_inicio;
        $this->fecha_fin = $evento->fecha_fin;
        $this->lugar = $evento->lugar;
        $this->capacidad = $evento->capacidad;
        }
    }

    public function isDirty(): bool
    {
        if (!$this->id_evento) {
            return true;
        }

        $db = Evento::find($this->id_evento);

        if (!$db) {
            return true;
        }

        $actual = self::arrayFilterRecursive([
            'nombre' => $this->nombre,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'lugar' => $this->lugar,
            'capacidad' => $this->capacidad,
        ], null, true);

        $original = self::arrayFilterRecursive([
            'nombre' => $db->nombre,
            'fecha_inicio' => $db->fecha_inicio,
            'fecha_fin' => $db->fecha_fin,
            'lugar' => $db->lugar,
            'capacidad' => $db->capacidad,
        ], null, true);

        return !self::sonIguales($actual, $original);
    }

    
}
