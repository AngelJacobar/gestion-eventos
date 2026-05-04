<?php

namespace App\Livewire\Forms\Usuarios;

use App\Models\Usuario;
use App\Rules\Alfanum1;
use App\Rules\IUnique;
use Illuminate\Support\Facades\DB;
use Livewire\Form;

class RegistrarUsuarioForm extends Form
{
    public $id_usuario;
    public $nombre = '';
    public $primer_apellido = '';
    public $segundo_apellido = '';
    public $email = '';
    public $rol = '';

    public $validationAttributes = [
        'nombre' => 'Nombre(s)',
        'primer_apellido' => 'Primer apellido',
        'segundo_apellido' => 'Segundo apellido',
        'email' => 'Correo electrónico',
        'rol' => 'Rol',
    ];

    public function setUsuario(?int $idUsuario = null)
    {
        $usuario = $idUsuario
        ? Usuario::findOrFail($idUsuario)
        : new Usuario();

        if ($usuario) {
            $this->id_usuario = $usuario->id_usuario;
            $this->nombre = $usuario->nombre;
            $this->primer_apellido = $usuario->primer_apellido;
            $this->segundo_apellido = $usuario->segundo_apellido;
            $this->email = $usuario->email;
            $this->rol = $usuario->roles->pluck('name')->first();
        }
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:3','max:50', new Alfanum1()],
            'primer_apellido' => ['required', 'string', 'min:3','max:50', new Alfanum1()],
            'segundo_apellido' => ['nullable', 'string', 'min:3','max:50', new Alfanum1()],
            'email' => ['required', 'max:150', 'email:rfc,dns',
                new IUnique(['usuario', DB::raw('lower(email)'), $this->id_usuario, 'id_usuario']),
            ],
            'rol' => ['required', 'string', 'max:50'],
        ];
    }
}
