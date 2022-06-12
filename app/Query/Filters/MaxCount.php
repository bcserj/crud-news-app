<?php

namespace App\Query\Filters;

use App\Query\Filter;

class MaxCount extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->take(request($this->filterName()));
    }

    public function value()
    {
        return request($this->filterName());
    }
}