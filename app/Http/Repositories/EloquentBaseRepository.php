<?php

namespace App\Http\Repositories;

use App\Models\Post;
use App\Query\BaseAction;
use App\Query\Filters\MaxCount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

abstract class EloquentBaseRepository
{
    protected Model $model;
    protected bool $usePipelines = false;


    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return BaseAction[]
     */
    abstract protected function pipelines(): array;

    public function all(): Collection
    {
        return ($this->usePipelines) ?
            $this->getPipelineQuery()->get() :
            $this->model->get();
    }

    public function paginate(int $count = 15)
    {
        return ($this->usePipelines) ?
            $this->getPipelineQuery()->paginate(MaxCount::value() ?? $count) :
            $this->model->paginate();
    }

    public function findById($id)
    {
        $builder = ($this->usePipelines) ? $this->getPipelineQuery() : $this->model;
        return $builder->findOrFail($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function throughPipeline(): static
    {
        if ($this->hasPipelines()) {
            $this->usePipelines = true;
        }

        return $this;
    }

    protected function hasPipelines(): bool
    {
        return count($this->pipelines()) > 0;
    }

    protected function getPipelineQuery(): Builder
    {
        return app(Pipeline::class)
            ->send($this->model->query())
            ->through($this->pipelines())
            ->thenReturn();
    }
}
