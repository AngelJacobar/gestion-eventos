<?php

namespace App\Livewire\Forms\Vista;

use Livewire\Form;

class BuscarEventosVistaForm extends Form
{
    public $fecha_inicio = '';
    public $fecha_fin = '';

    public $validationAttributes = [
        'fecha_inicio' => 'Fecha de inicio',
        'fecha_fin' => 'Fecha de fin',
    ];

    public function rules(): array
    {
        return [
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date'],
        ];
    }
}
