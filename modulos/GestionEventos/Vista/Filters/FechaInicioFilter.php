<?php

namespace Modulos\GestionEventos\Vista\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Modulos\Common\Filters\Filter;

class FechaInicioFilter extends Filter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        if (strlen($this->value) === 0) {
            return $next($query);
        }
        return $next($query->where('fecha_inicio', '<=', $this->value));
    }
}
