<?php

namespace App\Livewire\Forms\AsistenciaEvento;

use App\Traits\ArreglosMultidimensionalesHelper;
use Livewire\Form;
use Modulos\GestionEventos\Models\AsistenteEvento;

class RegistrarAsistenciaEventosForm extends Form
{
    use ArreglosMultidimensionalesHelper;

    public $id_asistente_evento;
    public $id_evento;
    public $id_usuario;
    public $fecha_registro;
    public $esEdicion;

   public function validationAttributes()
    {
        return [
            'id_evento' => 'Evento',
            'id_usuario' => 'Usuario',
            'fecha_registro' => 'Fecha de registro',
        ];
    }

    
    public function rules(): array
    {
        $fechaReglas = ['required', 'date'];
        if (! $this->esEdicion) {
            $fechaReglas[] = 'after_or_equal:today';
        }

        return [
            'id_evento' => ['required', 'integer', 'exists:evento,id_evento'],
            'id_usuario' => ['required', 'integer', 'exists:usuario,id_usuario'],
            'fecha_registro' => $fechaReglas,
        ];
    }

    public function messages()
    {
        return [
            "fecha_registro.after_or_equal" => "El campo :atribute no puede ser anterior al día de hoy.",
        ];
    }

    public function setDatos(?int $idAsistenciaEvento = null)
    {
        $this->id_asistente_evento = $idAsistenciaEvento;

        $asistenteEvento = $idAsistenciaEvento
        ? AsistenteEvento::findOrFail($idAsistenciaEvento)
        : new AsistenteEvento();
        $this->esEdicion = false;

        if ($idAsistenciaEvento) {
        $this->esEdicion = true;
        $this->id_evento = $asistenteEvento->id_evento;
        $this->id_usuario = $asistenteEvento->id_usuario;
        $this->fecha_registro = $asistenteEvento->fecha_registro;
        }
    }

    public function isDirty(): bool
    {
        if (!$this->id_asistente_evento) {
            return true;
        }

        $db = AsistenteEvento::find($this->id_asistente_evento);

        if (!$db) {
            return true;
        }

        $actual = self::arrayFilterRecursive([
            'id_evento' => $this->id_evento,
            'id_usuario' => $this->id_usuario,
            'fecha_registro' => $this->fecha_registro,
        ], null, true); 

        $original = self::arrayFilterRecursive([
            'id_evento' => $db->id_evento,
            'id_usuario' => $db->id_usuario,
            'fecha_registro' => $db->fecha_registro,
        ], null, true);

        return !self::sonIguales($actual, $original);
    }

    
}
