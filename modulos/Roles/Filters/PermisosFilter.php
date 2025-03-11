<?php

namespace Modulos\Roles\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Modulos\Common\Filters\Filter;

class PermisosFilter extends Filter
{
    public function handle(Builder $query, Closure $next): Builder
    {
        if (! is_array($this->value) || count($this->value) === 0) {
            return $next($query);
        }

        return $next($query->whereHas('permissions', function (Builder $query) {
            $query->whereIn('id', $this->value);
        }));
    }
}
