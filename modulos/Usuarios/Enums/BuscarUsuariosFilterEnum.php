<?php

namespace Modulos\Usuarios\Enums;

use Modulos\Common\Filters\Filter;
use Modulos\Usuarios\Filters\EmailFilter;
use Modulos\Usuarios\Filters\NombreFilter;
use Modulos\Usuarios\Filters\PrimerApellidoFilter;
use Modulos\Usuarios\Filters\RolFilter;
use Modulos\Usuarios\Filters\SegundoApellidoFilter;

enum BuscarUsuariosFilterEnum :string
{
    case Nombre = 'nombre';
    case PrimerApellido = 'primer_apellido';
    case SegundoApellido = 'segundo_apellido';
    case Email = 'email';
    case Rol = 'rol';

    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            self::Nombre => new NombreFilter($value),
            self::PrimerApellido => new PrimerApellidoFilter($value),
            self::SegundoApellido => new SegundoApellidoFilter($value),
            self::Email => new EmailFilter($value),
            self::Rol => new RolFilter($value),
        };
    }
}
