<?php

namespace App\Livewire\Forms\Eventos;

use App\Rules\Alfanum1;
use Livewire\Form;

class BuscarEventosForm extends Form
{
    public $nombre = '';
    public $lugar = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';

    public $validationAttributes = [
        'nombre' => 'Nombre',
        'lugar' => 'Lugar',
        'fecha_inicio' => 'Fecha de inicio',
        'fecha_fin' => 'Fecha de fin',
    ];

    public function rules(): array
    {
        return [
            'nombre' => ['nullable', 'string', 'max:100', new Alfanum1()],
            'lugar' => ['nullable', 'string', 'max:255', new Alfanum1()],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date'],
        ];
    }
}
