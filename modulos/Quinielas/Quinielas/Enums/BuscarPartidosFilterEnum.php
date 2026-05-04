<?php

namespace Modulos\Quinielas\Partidos\Enums;

use Modulos\Common\Filters\Filter;
use Modulos\Quinielas\Partidos\Filters\EstatusFilter;

enum BuscarPartidosFilterEnum :string
{
    case Estatus = 'estatus';
   
    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            self::Estatus => new EstatusFilter($value),
        };
    }
}
