<?php

namespace App\Http\Repositories;

use App\Models\Post;

class EloquentPostRepository extends EloquentBaseRepository
{
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }

    protected function pipelines(): array
    {
        return [
            \App\Query\Relations\User::class,
            \App\Query\Relations\Votes::class,
            \App\Query\Relations\Comments::class,
            \App\Query\Sort\Id::class,
            \App\Query\Filters\MaxCount::class
        ];
    }
}
