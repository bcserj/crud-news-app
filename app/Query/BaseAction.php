<?php

namespace App\Query;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class BaseAction
{
    public function handle($request, \Closure $next)
    {
        if (request()->has($this->actionName())) {
            return $this->applyAction($next($request));
        }
        return $next($request);
    }

    protected function actionName(): string
    {
        return Str::snake(class_basename($this));
    }

    protected function actionValue(): ?string
    {
        return request($this->actionName());
    }

    abstract protected function applyAction(Builder $builder);
}
