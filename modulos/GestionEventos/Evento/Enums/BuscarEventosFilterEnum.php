<?php

namespace Modulos\GestionEventos\Evento\Enums;

use Modulos\Common\Filters\Filter;
use Modulos\GestionEventos\Evento\Filters\FechaFinFilter;
use Modulos\GestionEventos\Evento\Filters\FechaInicioFilter;
use Modulos\GestionEventos\Evento\Filters\LugarFilter;
use Modulos\GestionEventos\Evento\Filters\NombreFilter;

enum BuscarEventosFilterEnum :string
{
    case Nombre = 'nombre';
    case Lugar = 'lugar';
    case FechaInicio = 'fecha_inicio';
    case FechaFin = 'fecha_fin';

    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            self::Nombre => new NombreFilter($value),
            self::Lugar => new LugarFilter($value),
            self::FechaInicio => new FechaInicioFilter($value),
            self::FechaFin => new FechaFinFilter($value),
        };
    }
}
