<?php

namespace App\Http\Controllers\API;

use App\Http\Repositories\EloquentCommentRepository;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends ApiController
{
    private EloquentCommentRepository $commentRepository;

    public function __construct(EloquentCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($postId): \Illuminate\Http\JsonResponse
    {
        $commentsCollection = $this->commentRepository->allByPost($postId);
        return $this->successResponse(
            CommentResource::collection(
                $commentsCollection
            )
        );
    }

    /**
     * @param $postId
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($postId, Comment $comment)
    {
        return $this->successResponse(
            new CommentResource($comment)
        );
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentRequest $request, Post $post)
    {
        if (
            auth()->check()
            && auth()->user()->can('create', Comment::class)
        ) {
            $comment = new Comment();
            $comment->fill($request->only(['content']));

            if ($post->comments()->save($comment)) {
                return $this->successResponse(
                    new CommentResource($comment->load('user'))
                );
            }
        }

        return $this->errorResponse([], 'Create comment error!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CommentRequest  $request
     * @param $postId
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CommentRequest $request, $postId, Comment $comment)
    {
        $status = false;

        if (
            auth()->check()
            && auth()->user()->can('update', $comment)
        ) {
            if ($comment->update($request->only(['comment']))) {
                return $this->successResponse(
                    new CommentResource($comment->load('user'))
                );
            }
        }

        return $this->errorResponse([], 'Update comment error!');
    }

    /**
     * @param $postId
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($postId, Comment $comment)
    {
        $status = false;

        if (
            auth()->check()
            && auth()->user()->can('delete', $comment)
        ) {
            if ($comment->delete()) {
                return $this->successResponse([], 'Comment deleted successfully');
            }
        }

        return $this->errorResponse(null, 'Delete comment error!');
    }
}
