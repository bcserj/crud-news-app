<?php

namespace App\Http\Controllers\API;

use App\Models\Post;

class VoteController extends ApiController
{
    public function upvote(Post $post)
    {
        if (auth()->user()->upvote($post)) {
            return $this->successResponse([], 'Successfully!');
        }
        return $this->errorResponse(null, 'Post already voted!');
    }

    public function downvote(Post $post)
    {
        if (auth()->user()->downvote($post)) {
            return $this->successResponse([], 'Successfully!');
        }
        return $this->errorResponse(null, 'You have not voted yet!');
    }
}
