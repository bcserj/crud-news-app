<?php

namespace App\Query\Relations;

use App\Query\Filter;

class Comments extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->with($this->filterName());
    }
}