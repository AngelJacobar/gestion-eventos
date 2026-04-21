<?php

namespace Modulos\GestionEventos\Sesiones\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Modulos\Common\Filters\Filter;

class PonenteFilter extends Filter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        if (strlen($this->value) === 0) {
            return $next($query);
        }
        return $next($query->whereRaw('unaccent(ponente) ILIKE unaccent(?)', ["%{$this->value}%"]));
    }
}
