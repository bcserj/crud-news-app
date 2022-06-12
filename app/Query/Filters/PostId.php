<?php

namespace App\Query\Filters;

use App\Query\Filter;

class PostId extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where($this->filterName(), request($this->filterName()));
    }
}