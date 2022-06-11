<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentBaseRepository
{
    protected Model $model;

    public function all(array $relations = []): Collection
    {
        return (count($relations)) ?
            $this->model->with($relations)->get()
            : $this->model->get();
    }

    public function findById($id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }
}