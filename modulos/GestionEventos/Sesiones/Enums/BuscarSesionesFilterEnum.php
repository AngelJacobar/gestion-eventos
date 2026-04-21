<?php

namespace Modulos\GestionEventos\Sesiones\Enums;

use Modulos\Common\Filters\Filter;
use Modulos\GestionEventos\Sesiones\Filters\NombreFilter;
use Modulos\GestionEventos\Sesiones\Filters\FechaFilter;
use Modulos\GestionEventos\Sesiones\Filters\HoraInicioFilter;
use Modulos\GestionEventos\Sesiones\Filters\HoraFinFilter;
use Modulos\GestionEventos\Sesiones\Filters\EventoFilter;
use Modulos\GestionEventos\Sesiones\Filters\PonenteFilter;

enum BuscarSesionesFilterEnum :string
{
    case Nombre = 'nombre';
    case Evento = 'id_evento';
    case Fecha = 'fecha';
    case HoraInicio = 'hora_inicio';
    case HoraFin = 'hora_fin';
    case Ponente = 'ponente';

    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            self::Nombre => new NombreFilter($value),
            self::Evento => new EventoFilter($value),
            self::Fecha => new FechaFilter($value),
            self::HoraInicio => new HoraInicioFilter($value),
            self::HoraFin => new HoraFinFilter($value),
            self::Ponente => new PonenteFilter($value),
        };
    }
}
