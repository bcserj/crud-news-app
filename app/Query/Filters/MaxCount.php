<?php

namespace App\Query\Filters;

use Illuminate\Database\Eloquent\Builder;

class MaxCount extends BaseFilter
{
    protected function applyAction($builder): Builder
    {
        return $builder->take(request($this->actionName()));
    }
}
