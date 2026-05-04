<?php

namespace App\Livewire\Forms\Partidos;

use Livewire\Form;

class BuscarPartidosForm extends Form
{
    public $estatus = '';

    public $validationAttributes = [
        'estatus' => 'Estatus',
    ];

    public function rules(): array
    {
        return [
            'estatus' => ['nullable'],
        ];
    }
}
