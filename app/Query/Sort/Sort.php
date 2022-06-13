<?php

namespace App\Query\Sort;

use App\Query\BaseAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class Sort extends BaseAction
{
    protected function applyAction($builder): Builder
    {
        return $builder->orderBy($this->columnName(), $this->actionValue());
    }

    protected function actionName(): string
    {
        return 'sort_' . parent::actionName();
    }

    protected function columnName(): string
    {
        return Str::snake(class_basename($this));
    }
}
