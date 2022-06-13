<?php

namespace App\Query\Relations;

use App\Query\BaseAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class BaseRelation extends BaseAction
{
    protected function applyAction($builder): Builder
    {
        return $builder->with($this->actionName());
    }

    protected function actionName(): string
    {
        return Str::replace('_', '.', parent::actionName());
    }

    public function getRelationName(): string
    {
        return $this->actionName();
    }
}
