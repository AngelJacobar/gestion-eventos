<?php

namespace Modulos\GestionEventos\AsistenciaEvento\Enums;

use Modulos\Common\Filters\Filter;
use Modulos\GestionEventos\AsistenciaEvento\Filters\FechaFilter;
use Modulos\GestionEventos\AsistenciaEvento\Filters\EventoFilter;
use Modulos\GestionEventos\AsistenciaEvento\Filters\UsuarioFilter;

enum BuscarAsistenciaEventosFilterEnum :string
{
    case Evento = 'id_evento';
    case Fecha = 'fecha_registro';
    case Usuario = 'id_usuario';
   
    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            self::Evento => new EventoFilter($value),
            self::Fecha => new FechaFilter($value),
            self::Usuario => new UsuarioFilter($value),
        };
    }
}
