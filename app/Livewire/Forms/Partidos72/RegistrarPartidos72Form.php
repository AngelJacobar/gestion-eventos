<?php

namespace App\Livewire\Forms\Partidos72;

use App\Traits\ArreglosMultidimensionalesHelper;
use Livewire\Form;
use Modulos\Quinielas\Models\Partidos72;

class RegistrarPartidos72Form extends Form
{
    use ArreglosMultidimensionalesHelper;

    public $id_partido_72;
    public $numero_partido;
    public $equipo_local;
    public $equipo_visitante;
    public $resultado;
    public $esEdicion = false;

    public function validationAttributes()
    {
        return [
            'numero_partido' => 'Número de partido',
            'equipo_local' => 'Equipo local',
            'equipo_visitante' => 'Equipo visitante',
            'resultado' => 'Resultado',
        ];
    }

    public function rules(): array
    {
        return [
            'numero_partido' => ['required', 'integer', 'min:1', 'max:72'],
            'equipo_local' => ['required', 'string', 'max:100'],
            'equipo_visitante' => ['required', 'string', 'max:100'],
            'resultado' => ['nullable', 'string', 'in:L,V,E'],
        ];
    }

    public function messages()
    {
        return [
            "resultado.in" => "El resultado debe ser L (Local), V (Visitante) o E (Empate).",
            "numero_partido.max" => "El número de partido no puede ser mayor a 72.",
        ];
    }

    public function setDatos(?int $idPartido72 = null)
    {
        $this->id_partido_72 = $idPartido72;

        $partido = $idPartido72
            ? Partidos72::findOrFail($idPartido72)
            : new Partidos72();
        $this->esEdicion = false;

        if ($idPartido72) {
            $this->esEdicion = true;
            $this->id_partido_72 = $partido->id_partido_72;
            $this->numero_partido = $partido->numero_partido;
            $this->equipo_local = $partido->equipo_local;
            $this->equipo_visitante = $partido->equipo_visitante;
            $this->resultado = $partido->resultado;
        }
    }

    public function isDirty(): bool
    {
        if (!$this->id_partido_72) {
            return true;
        }

        $db = Partidos72::find($this->id_partido_72);

        if (!$db) {
            return true;
        }

        $actual = self::arrayFilterRecursive([
            'numero_partido' => $this->numero_partido,
            'equipo_local' => $this->equipo_local,
            'equipo_visitante' => $this->equipo_visitante,
            'resultado' => $this->resultado,
        ], null, true);

        $original = self::arrayFilterRecursive([
            'numero_partido' => $db->numero_partido,
            'equipo_local' => $db->equipo_local,
            'equipo_visitante' => $db->equipo_visitante,
            'resultado' => $db->resultado,
        ], null, true);

        return !self::sonIguales($actual, $original);
    }
}
