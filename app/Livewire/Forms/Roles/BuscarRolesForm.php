<?php

namespace App\Livewire\Forms\Roles;

use App\Rules\Alfanum1;
use Livewire\Form;

class BuscarRolesForm extends Form
{
    public $nombre = '';
    public $permisos = [];

    public $validationAttributes = [
        'nombre' => 'Nombre',
        'permisos' => 'Permisos',
    ];

    public function rules(): array
    {
        return [
            'nombre' => ['nullable', 'string',  new Alfanum1()],
            'permisos' => ['nullable', 'array'],
        ];
    }
}
