<?php

namespace App\Livewire\Forms\AsistenciaEvento;

use App\Rules\Alfanum1;
use Livewire\Form;

class BuscarAsistenciaEventosForm extends Form
{
    public $id_evento = '';
    public $id_usuario = '';
    public $fecha_registro = '';

    public $validationAttributes = [
        'id_evento' => 'ID del evento',
        'id_usuario' => 'ID del usuario',
        'fecha_registro' => 'Fecha de registro',
    ];

    public function rules(): array
    {
        return [
            'id_evento' => ['nullable', 'string', 'max:100', new Alfanum1()],
            'id_usuario' => ['nullable', 'string', 'max:255', new Alfanum1()],
            'fecha_registro' => ['nullable', 'date'],
        ];
    }
}
