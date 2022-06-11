<?php

namespace App\Http\Repositories;

use App\Models\Post;

class EloquentPostRepository extends EloquentBaseRepository
{
    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function findByUserId($postId, $userId): ?Post
    {
        return $this->model->filterByUser($userId)->findOrFail($postId);
    }
}