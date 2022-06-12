<?php

namespace App\Http\Repositories;

use App\Models\Post;
use App\Query\Filters\MaxCount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pipeline\Pipeline;

class EloquentPostRepository extends EloquentBaseRepository
{
    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function all(array $relations = []): Collection
    {
        return $this->getMainQuery()->get();
    }

    public function paginate()
    {
        return $this->getMainQuery()->paginate((new MaxCount())->value() ?? 10);
    }

    protected function getMainQuery()
    {
        $query = $this->model->newQuery();
        return app(Pipeline::class)
            ->send($query)
            ->through([
                \App\Query\Relations\User::class,
                \App\Query\Relations\Votes::class,
                \App\Query\Relations\Comments::class,
                \App\Query\Sort::class,
                \App\Query\Filters\MaxCount::class
            ])
            ->thenReturn();
    }


}
