<?php

namespace App\Http\Repositories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class EloquentCommentRepository extends EloquentBaseRepository
{
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    public function allByPost($postId): ?Collection
    {
        return $this->model->with(['user'])->where('post_id', $postId)->get();
    }
}
