<?php

namespace App\Livewire\Forms\Sesiones;

use App\Traits\ArreglosMultidimensionalesHelper;
use Livewire\Form;
use Modulos\GestionEventos\Models\Sesion;

class RegistrarSesionesForm extends Form
{
    use ArreglosMultidimensionalesHelper;

    public $id_sesion;
    public $id_evento;
    public $nombre;
    public $fecha;
    public $hora_inicio;
    public $hora_fin;
    public $ponente;
    public $esEdicion;

   public function validationAttributes()
    {
        return [
            'id_evento' => 'Evento',
            'nombre' => 'Nombre',
            'fecha' => 'Fecha',
            'hora_inicio' => 'Hora de inicio',
            'hora_fin' => 'Hora de fin',
            'ponente' => 'Ponente',
        ];  
    }

    
    public function rules(): array
    {
        return [
            'id_evento' => ['required', 'integer', 'exists:evento,id_evento'],
            'nombre' => ['required', 'string', 'max:255'],
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'hora_inicio' => ['required', ],
            'hora_fin' => ['required',  'after_or_equal:hora_inicio'],
            'ponente' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            "fecha.after_or_equal" => "El campo :atribute no puede ser anterior al día de hoy.",
            "hora_fin.after_or_equal" => "El campo :atribute no puede ser menor a la hora de inicio.", 
        ];
    }

    public function setDatos(?int $idSesion = null)
    {
        $this->id_sesion = $idSesion;

        $sesion = $idSesion
        ? Sesion::findOrFail($idSesion)
        : new Sesion();
        $this->esEdicion = false;

        if ($idSesion) {
        $this->esEdicion = true;
        $this->id_evento = $sesion->id_evento;
        $this->nombre = $sesion->nombre;
        $this->fecha = $sesion->fecha;
        $this->hora_inicio = $sesion->hora_inicio;
        $this->hora_fin = $sesion->hora_fin;
        $this->ponente = $sesion->ponente;
        }
    }

    public function isDirty(): bool
    {
        if (!$this->id_evento) {
            return true;
        }

        $db = Sesion::find($this->id_sesion);

        if (!$db) {
            return true;
        }

        $actual = self::arrayFilterRecursive([
            'id_evento' => $this->id_evento,
            'nombre' => $this->nombre,
            'fecha' => $this->fecha,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'ponente' => $this->ponente,
        ], null, true);

        $original = self::arrayFilterRecursive([
            'id_evento' => $db->id_evento,
            'nombre' => $db->nombre,
            'fecha' => $db->fecha,
            'hora_inicio' => $db->hora_inicio,
            'hora_fin' => $db->hora_fin,
            'ponente' => $db->ponente,
        ], null, true);

        return !self::sonIguales($actual, $original);
    }

    
}
