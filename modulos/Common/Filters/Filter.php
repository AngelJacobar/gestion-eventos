<?php

namespace Modulos\Common\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(protected readonly mixed $value)
    {
    }

    abstract public function handle(Builder $query, Closure $next): Builder;
}
