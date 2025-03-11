<?php

namespace App\Livewire\Forms\Usuarios;

use App\Rules\Alfanum1;
use Livewire\Form;

class BuscarUsuariosForm extends Form
{
    public $nombre = '';
    public $primer_apellido = '';
    public $segundo_apellido = '';
    public $email = '';
    public $rol = '';

    public $validationAttributes = [
        'nombre' => 'Nombre(s)',
        'primer_apellido' => 'Primer apellido',
        'segundo_apellido' => 'Segundo apellido',
        'email' => 'Email',
        'rol' => 'Rol',
    ];

    public function rules(): array
    {
        return [
            'nombre' => ['nullable', 'string', 'max:50', new Alfanum1()],
            'primer_apellido' => ['nullable', 'string', 'max:50', new Alfanum1()],
            'segundo_apellido' => ['nullable', 'string', 'max:50', new Alfanum1()],
            'email' => ['nullable', 'string', 'max:150'],
            'rol' => ['nullable', 'string', 'max:50'],
        ];
    }
}
