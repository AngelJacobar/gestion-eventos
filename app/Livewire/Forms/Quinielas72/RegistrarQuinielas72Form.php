<?php

namespace App\Livewire\Forms\Quinielas72;

use App\Traits\ArreglosMultidimensionalesHelper;
use Carbon\Carbon;
use Livewire\Form;
use Modulos\Quinielas\Models\Quinielas72;
use Modulos\Quinielas\Models\QuinielasDetalle72;

class RegistrarQuinielas72Form extends Form
{
    use ArreglosMultidimensionalesHelper;

    public $id_quiniela_72;
    public $jornada;
    public $nombre;
    public $telefono;
    public $puntaje_total;
    public $estatus;
    public $fecha_registro;
    public $esEdicion = false;

    // Array para manejar los pronósticos de los 72 partidos
    // Formato: ['id_partido_72' => 'pronostico']
    public $pronosticos = [];

    public function validationAttributes()
    {
        return [
            'jornada' => 'Jornada',
            'nombre' => 'Nombre',
            'telefono' => 'Teléfono',
            'puntaje_total' => 'Puntaje total',
            'estatus' => 'Estatus',
            'fecha_registro' => 'Fecha de registro',
            'pronosticos.*' => 'Pronóstico',
        ];
    }

    public function rules(): array
    {
        return [
            'jornada' => ['nullable', 'string', 'max:50'],
            'nombre' => ['required', 'string', 'max:100'],
            'telefono' => ['nullable', 'regex:/^\d{10}$/'],
            'puntaje_total' => ['nullable', 'integer', 'min:0'],
            'estatus' => ['nullable', 'string', 'max:1'],
            'fecha_registro' => ['nullable', 'date'],
            'pronosticos' => ['required', 'array', 'size:72'],
            'pronosticos.*' => ['required', 'string', 'in:L,V,E'],
        ];
    }

    public function messages()
    {
        return [
            'telefono.regex' => 'El teléfono debe contener exactamente 10 dígitos sin guiones.',
            'pronosticos.required' => 'Debe proporcionar pronósticos para todos los partidos.',
            'pronosticos.size' => 'Debe proporcionar exactamente 72 pronósticos.',
            'pronosticos.*.required' => 'Cada pronóstico es obligatorio.',
            'pronosticos.*.in' => 'Cada pronóstico debe ser L (Local), V (Visitante) o E (Empate).',
        ];
    }

    public function setDatos(?int $idQuiniela72 = null)
    {
        $this->id_quiniela_72 = $idQuiniela72;

        $quiniela = $idQuiniela72
            ? Quinielas72::with('detalles')->findOrFail($idQuiniela72)
            : new Quinielas72();
        $this->esEdicion = false;

        if ($idQuiniela72) {
            $this->esEdicion = true;
            $this->id_quiniela_72 = $quiniela->id_quiniela_72;
            $this->jornada = $quiniela->jornada;
            $this->nombre = $quiniela->nombre;
            $this->telefono = $quiniela->telefono;
            $this->puntaje_total = $quiniela->puntaje_total;
            $this->estatus = $quiniela->estatus;
            $this->fecha_registro = Carbon::parse($quiniela->fecha_registro)->format('Y-m-d');

            // Cargar los pronósticos existentes
            $this->pronosticos = [];
            foreach ($quiniela->detalles as $detalle) {
                $this->pronosticos[$detalle->id_partido_72] = $detalle->pronostico;
            }
        }
    }

    public function isDirty(): bool
    {
        if (!$this->id_quiniela_72) {
            return true;
        }

        $db = Quinielas72::with('detalles')->find($this->id_quiniela_72);

        if (!$db) {
            return true;
        }

        $actual = self::arrayFilterRecursive([
            'jornada' => $this->jornada,
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'estatus' => $this->estatus,
        ], null, true);

        $original = self::arrayFilterRecursive([
            'jornada' => $db->jornada,
            'nombre' => $db->nombre,
            'telefono' => $db->telefono,
            'estatus' => $db->estatus,
        ], null, true);

        if (!self::sonIguales($actual, $original)) {
            return true;
        }

        // Verificar si los pronósticos cambiaron
        $pronosticosOriginales = [];
        foreach ($db->detalles as $detalle) {
            $pronosticosOriginales[$detalle->id_partido_72] = $detalle->pronostico;
        }

        return !self::sonIguales($this->pronosticos, $pronosticosOriginales);
    }
}
