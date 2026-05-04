<?php

namespace Modulos\Usuarios\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Modulos\Common\Filters\Filter;

class NombreFilter extends Filter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        if (strlen($this->value) === 0) {
            return $next($query);
        }
        return $next($query->whereRaw('unaccent(nombre) ILIKE unaccent(?)', ["%{$this->value}%"]));
    }
}
