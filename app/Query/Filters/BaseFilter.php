<?php

namespace App\Query\Filters;

use App\Query\BaseAction;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static value
 */
abstract class BaseFilter extends BaseAction
{
    public static function __callStatic(string $method, array $arguments)
    {
        return match ($method) {
            'value' => (new static())->getValue(),
            default => throw new \InvalidArgumentException("$method cant be called statically!")
        };
    }

    protected function applyAction($builder): Builder
    {
        return $builder->where($this->actionName(), $this->actionValue());
    }

    public function getValue(): ?string
    {
        return $this->actionValue();
    }
}
