<?php

namespace Modulos\Quinielas\Partidos\Enums;

use Modulos\Common\Filters\Filter;

enum BuscarPartidosFilterEnum :string
{
    // No hay filtros disponibles actualmente
   
    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            // Sin casos definidos
        };
    }
}
