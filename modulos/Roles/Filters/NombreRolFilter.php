<?php

namespace Modulos\Roles\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Modulos\Common\Filters\Filter;

class NombreRolFilter extends Filter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        if (strlen($this->value) === 0) {
            return $next($query);
        }

        return $next($query->whereRaw('unaccent(name) ILIKE unaccent(?)', ["%{$this->value}%"]));
    }
}
