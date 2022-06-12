<?php

namespace App\Query;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle($request, \Closure $next)
    {
        if (request()->has($this->filterName())) {
            return $this->applyFilter($next($request));
        }

        return $next($request);
    }

    protected function filterName()
    {
        return Str::snake(class_basename($this));
    }

    abstract protected function applyFilter(Builder $builder);
}