<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * @param  \App\Models\Post $post
     * @return void
     */
    public function creating(Post $post)
    {
        if ($post->isClean('user_id')) {
            $post->user_id = auth()->user()->getAuthIdentifier();
        }
    }

    public function deleting(Post $post)
    {
        $post->comments()->delete();
        $post->votes()->delete();
    }
}
