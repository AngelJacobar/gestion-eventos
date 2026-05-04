<?php

namespace Modulos\Roles\Enums;

use Modulos\Common\Filters\Filter;
use Modulos\Roles\Filters\NombreRolFilter;
use Modulos\Roles\Filters\PermisosFilter;

enum BuscarRolesFilterEnum :string
{
    case Nombre = 'nombre';
    case Permisos = 'permisos';

    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            self::Nombre => new NombreRolFilter($value),
            self::Permisos => new PermisosFilter($value),
        };
    }
}
