<?php

namespace App\Http\Repositories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class EloquentCommentRepository extends EloquentBaseRepository
{
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }

    protected function pipelines(): array
    {
        return [
            \App\Query\Relations\User::class,
            \App\Query\Relations\Post::class,
            \App\Query\Sort\Id::class,
            \App\Query\Filters\MaxCount::class
        ];
    }

    public function findByPostId($postId): ?Collection
    {
        $builder = ($this->usePipelines) ? $this->getPipelineQuery() : $this->model;
        return $builder->where('post_id', $postId)->get();
    }
}
