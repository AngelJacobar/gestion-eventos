<?php

namespace Modulos\GestionEventos\Vista\Enums;

use Modulos\Common\Filters\Filter;
use Modulos\GestionEventos\Vista\Filters\FechaFinFilter;
use Modulos\GestionEventos\Vista\Filters\FechaInicioFilter;

enum BuscarEventosVistaFilterEnum :string
{   
    case FechaInicio = 'fecha_inicio';
    case FechaFin = 'fecha_fin';

    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            self::FechaInicio => new FechaInicioFilter($value),
            self::FechaFin => new FechaFinFilter($value),
        };
    }
}
