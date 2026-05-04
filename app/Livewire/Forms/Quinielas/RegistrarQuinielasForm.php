<?php

namespace App\Livewire\Forms\Quinielas;

use App\Traits\ArreglosMultidimensionalesHelper;
use Carbon\Carbon;
use Livewire\Form;
use Modulos\Quinielas\Models\Quinielas;

class RegistrarQuinielasForm extends Form
{
    use ArreglosMultidimensionalesHelper;

    public $id_quiniela;
    public $jornada;
    public $nombre;
    public $telefono;
    public $pronostico_1;
    public $pronostico_2;
    public $pronostico_3;
    public $pronostico_4;
    public $pronostico_5;
    public $pronostico_6;
    public $pronostico_7;
    public $pronostico_8;
    public $pronostico_9;
    public $puntaje_total;
    public $estatus;
    public $fecha_registro;
    public $esEdicion = false;

   public function validationAttributes()
    {
        return [
            'jornada' => 'Jornada',
            'nombre' => 'Nombre',
            'telefono' => 'Teléfono',
            'pronostico_1' => 'Pronóstico 1',
            'pronostico_2' => 'Pronóstico 2',
            'pronostico_3' => 'Pronóstico 3',
            'pronostico_4' => 'Pronóstico 4',
            'pronostico_5' => 'Pronóstico 5',
            'pronostico_6' => 'Pronóstico 6',
            'pronostico_7' => 'Pronóstico 7',
            'pronostico_8' => 'Pronóstico 8',
            'pronostico_9' => 'Pronóstico 9',
            'puntaje_total' => 'Puntaje total',
            'estatus' => 'Estatus',
            'fecha_registro' => 'Fecha de registro',
        ];
    }

    
    public function rules(): array
    {
        return [
            'jornada' => ['nullable', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:10'],
            'pronostico_1' => ['required', 'string', 'max:1', 'in:L,V,E'],
            'pronostico_2' => ['required', 'string', 'max:1', 'in:L,V,E'],
            'pronostico_3' => ['required', 'string', 'max:1', 'in:L,V,E'],
            'pronostico_4' => ['required', 'string', 'max:1', 'in:L,V,E'],
            'pronostico_5' => ['required', 'string', 'max:1', 'in:L,V,E'],
            'pronostico_6' => ['required', 'string', 'max:1', 'in:L,V,E'],
            'pronostico_7' => ['required', 'string', 'max:1', 'in:L,V,E'],
            'pronostico_8' => ['required', 'string', 'max:1', 'in:L,V,E'],
            'pronostico_9' => ['required', 'string', 'max:1', 'in:L,V,E'],
            'puntaje_total' => ['nullable', 'integer', 'min:0'],
            'estatus' => ['nullable', 'string', 'max:1'],
            'fecha_registro' => ['nullable', 'date'],
        ];
    }

  

    public function setDatos(?int $idQuiniela = null)
    {
        $this->id_quiniela = $idQuiniela;

        $quiniela = $idQuiniela
        ? Quinielas::findOrFail($idQuiniela)
        : new Quinielas();
        $this->esEdicion = false;

        if ($idQuiniela) {
        $this->esEdicion = true;
        $this->id_quiniela = $quiniela->id_quiniela;
        $this->jornada = $quiniela->jornada;
        $this->nombre = $quiniela->nombre;
        $this->telefono = $quiniela->telefono;
        $this->pronostico_1 = $quiniela->pronostico_1;
        $this->pronostico_2 = $quiniela->pronostico_2;
        $this->pronostico_3 = $quiniela->pronostico_3;
        $this->pronostico_4 = $quiniela->pronostico_4;
        $this->pronostico_5 = $quiniela->pronostico_5;
        $this->pronostico_6 = $quiniela->pronostico_6;
        $this->pronostico_7 = $quiniela->pronostico_7;
        $this->pronostico_8 = $quiniela->pronostico_8;
        $this->pronostico_9 = $quiniela->pronostico_9;
        $this->puntaje_total = $quiniela->puntaje_total;
        $this->estatus = $quiniela->estatus;
        $this->fecha_registro = Carbon::parse($quiniela->fecha_registro)->format('Y-m-d');
        }
    }

    public function isDirty(): bool
    {
        if (!$this->id_quiniela) {
            return true;
        }

        $db = Quinielas::find($this->id_quiniela);

        if (!$db) {
            return true;
        }

        $actual = self::arrayFilterRecursive([
            'jornada' => $this->jornada,
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'pronostico_1' => $this->pronostico_1,
            'pronostico_2' => $this->pronostico_2,
            'pronostico_3' => $this->pronostico_3,
            'pronostico_4' => $this->pronostico_4,
            'pronostico_5' => $this->pronostico_5,
            'pronostico_6' => $this->pronostico_6,
            'pronostico_7' => $this->pronostico_7,
            'pronostico_8' => $this->pronostico_8,
            'pronostico_9' => $this->pronostico_9,
            'puntaje_total' => $this->puntaje_total,
            'estatus' => $this->estatus,
            'fecha_registro' => $this->fecha_registro,
        ], null, true);

        $original = self::arrayFilterRecursive([
            'jornada' => $this->jornada,
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'pronostico_1' => $this->pronostico_1,
            'pronostico_2' => $this->pronostico_2,
            'pronostico_3' => $this->pronostico_3,
            'pronostico_4' => $this->pronostico_4,
            'pronostico_5' => $this->pronostico_5,
            'pronostico_6' => $this->pronostico_6,
            'pronostico_7' => $this->pronostico_7,
            'pronostico_8' => $this->pronostico_8,
            'pronostico_9' => $this->pronostico_9,
            'puntaje_total' => $this->puntaje_total,
            'estatus' => $this->estatus,
            'fecha_registro' => $this->fecha_registro,
        ], null, true);

        return !self::sonIguales($actual, $original);
    }

      

    
}
