<?php

namespace Modulos\GestionEventos\AsistenciaEvento\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Modulos\Common\Filters\Filter;

class FechaFilter extends Filter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        if (strlen($this->value) === 0) {
            return $next($query);
        }
        return $next($query->where('fecha_registro', '=', $this->value));
    }
}
