<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    /**
     * @param  Comment $comment
     * @return void
     */
    public function creating(Comment $comment): void
    {
        if ($comment->isClean('user_id')) {
            $comment->user_id = auth()->user()->getAuthIdentifier();
        }
    }
}
