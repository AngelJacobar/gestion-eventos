<?php

namespace App\Livewire\Forms\Roles;

use App\Rules\Alfanum1;
use App\Rules\IUnique;
use Illuminate\Support\Facades\DB;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class RegistrarRolForm extends Form
{
    public $id_rol;
    public $nombre = '';
    public $permisos = [];

    public $validationAttributes = [
        'nombre' => 'Nombre',
        'permisos' => 'Permisos',
    ];

    public function setRole(?int $idRole = null)
    {
        $rol = $idRole
        ? Role::findOrFail($idRole)
        : new Role();

        if ($rol->exists) {
            $this->id_rol = $rol->id;
            $this->nombre = $rol->name;
            $this->permisos = $rol->permissions->pluck('id')->toArray();
        }
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
                new Alfanum1(),
                new IUnique(['roles', DB::raw('lower(name)'), $this->id_rol, 'id']),
            ],
            'permisos' => 'required|array',
        ];
    }
}
