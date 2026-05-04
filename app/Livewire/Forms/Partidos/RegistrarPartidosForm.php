<?php

namespace App\Livewire\Forms\Partidos;

use App\Traits\ArreglosMultidimensionalesHelper;
use Carbon\Carbon;
use Livewire\Form;
use Modulos\Quinielas\Models\PartidosSemana;

class RegistrarPartidosForm extends Form
{
    use ArreglosMultidimensionalesHelper;

    public $id_partido;
    public $jornada;
    public $numero_partido;
    public $equipo_local;
    public $equipo_visitante;
    public $fecha_partido;
    public $resultado;
    public $estatus;
    public $fecha_inicio_jornada;
    public $fecha_fin_jornada;
    public $esEdicion = false;

   public function validationAttributes()
    {
        return [
            'jornada' => 'Jornada',
            'numero_partido' => 'Número de partido',
            'equipo_local' => 'Equipo local',
            'equipo_visitante' => 'Equipo visitante',
            'fecha_partido' => 'Fecha del partido',
            'resultado' => 'Resultado',
            'estatus' => 'Estatus',
            'fecha_inicio_jornada' => 'Fecha de inicio de jornada',
            'fecha_fin_jornada' => 'Fecha de fin de jornada',
        ];
    }

    
    public function rules(): array
    {
        return [
            'jornada' => ['required', 'string', 'max:255'],
            'numero_partido' => ['required', 'integer', 'min:1'],
            'equipo_local' => ['required', 'string', 'max:255'],
            'equipo_visitante' => ['required', 'string', 'max:255'],
            'fecha_partido' => ['required', 'date', ],
            'resultado' => ['nullable', 'string', 'in:L,V,E'],
            'estatus' => ['nullable', 'string', 'max:1'],
            'fecha_inicio_jornada' => ['required', 'date', ],
            'fecha_fin_jornada' => ['required', 'date', 'after_or_equal:fecha_inicio_jornada'],
        ];
    }

    public function messages()
    {
        return [
            "fecha_inicio_jornada.after_or_equal" => "El campo :atribute no puede ser anterior al día de hoy.",
            "fecha_fin_jornada.after_or_equal" => "El campo :atribute no puede ser menor a la fecha de inicio de la jornada.",
            "resultado.in" => "El resultado debe ser L (Local), V (Visitante) o E (Empate).", 
        ];
    }

    public function setDatos(?int $idPartido = null)
    {
        $this->id_partido = $idPartido;

        $partido = $idPartido
        ? PartidosSemana::findOrFail($idPartido)
        : new PartidosSemana();
        $this->esEdicion = false;

        if ($idPartido) {
        $this->esEdicion = true;
        $this->id_partido = $partido->id_partido;
        $this->jornada = $partido->jornada;
        $this->numero_partido = $partido->numero_partido;
        $this->equipo_local = $partido->equipo_local;
        $this->equipo_visitante = $partido->equipo_visitante;
        $this->fecha_partido = $partido->fecha_partido ? Carbon::parse($partido->fecha_partido)->format('Y-m-d') : null;
        $this->resultado = $partido->resultado;
        $this->estatus = $partido->estatus;
        $this->fecha_inicio_jornada = $partido->fecha_inicio_jornada ? Carbon::parse($partido->fecha_inicio_jornada)->format('Y-m-d') : null;
        $this->fecha_fin_jornada = $partido->fecha_fin_jornada ? Carbon::parse($partido->fecha_fin_jornada)->format('Y-m-d') : null;
        }
    }

    public function isDirty(): bool
    {
        if (!$this->id_partido) {
            return true;
        }

        $db = PartidosSemana::find($this->id_partido);

        if (!$db) {
            return true;
        }

        $actual = self::arrayFilterRecursive([
            'jornada' => $this->jornada,
            'numero_partido' => $this->numero_partido,
            'equipo_local' => $this->equipo_local,
            'equipo_visitante' => $this->equipo_visitante,
            'fecha_partido' => $this->fecha_partido,
            'resultado' => $this->resultado,
            'estatus' => $this->estatus,
            'fecha_inicio_jornada' => $this->fecha_inicio_jornada,
            'fecha_fin_jornada' => $this->fecha_fin_jornada,
        ], null, true);

        $original = self::arrayFilterRecursive([
            'jornada' => $db->jornada,
            'numero_partido' => $db->numero_partido,
            'equipo_local' => $db->equipo_local,
            'equipo_visitante' => $db->equipo_visitante,
            'fecha_partido' => $db->fecha_partido,
            'resultado' => $db->resultado,
            'estatus' => $db->estatus,
            'fecha_inicio_jornada' => $db->fecha_inicio_jornada,
            'fecha_fin_jornada' => $db->fecha_fin_jornada,
        ], null, true);

        return !self::sonIguales($actual, $original);
    }

      

    
}
