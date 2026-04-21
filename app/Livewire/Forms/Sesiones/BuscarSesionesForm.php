<?php

namespace App\Livewire\Forms\Sesiones;

use App\Rules\Alfanum1;
use Livewire\Form;

class BuscarSesionesForm extends Form
{
    public $nombre = '';
    public $id_evento = '';
    public $fecha = '';
    public $hora_inicio = '';
    public $hora_fin = '';
    public $ponente = '';

    public $validationAttributes = [
        'nombre' => 'Nombre',
        'id_evento' => 'Evento',
        'fecha' => 'Fecha',
        'hora_inicio' => 'Hora de inicio',
        'hora_fin' => 'Hora de fin',
        'ponente' => 'Ponente',
    ];  

    public function rules(): array
    {
        return [
            'nombre' => ['nullable', 'string', 'max:100', new Alfanum1()],
            'id_evento' => ['nullable', 'integer'],
            'fecha' => ['nullable', 'date'],
            'hora_inicio' => ['nullable', 'date_format:H:i'],
            'hora_fin' => ['nullable', 'date_format:H:i'],
            'ponente' => ['nullable', 'string', 'max:100', new Alfanum1()],
        ];
    }
}
