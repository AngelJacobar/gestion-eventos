<?php

namespace Modulos\Usuarios\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Modulos\Common\Filters\Filter;

class RolFilter extends Filter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        if (strlen($this->value) === 0 || $this->value === 'todos') {
            return $next($query);
        }

        return $next($query->where('roles.name', $this->value));
    }
}
