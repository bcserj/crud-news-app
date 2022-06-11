<?php

namespace App\Http\Controllers\API;

use App\Http\Repositories\EloquentPostRepository;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends ApiController
{
    private EloquentPostRepository $postRepository;

    public function __construct(EloquentPostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        return $this->successResponse(
            PostResource::collection(
                $this->postRepository->all(['user', 'votes'])
            )
        );
    }

    /**
     * @param $postId
     * @return JsonResponse
     */
    public function show(Post $post): JsonResponse
    {
        return $this->successResponse(
            new PostResource($post->load(['user', 'votes']))
        );
    }

    /**
     * @param  PostRequest  $postStoreRequest
     * @return JsonResponse
     */
    public function store(PostRequest $postStoreRequest): JsonResponse
    {
        if (
            auth()->check()
            && ($user = auth()->user())
            && $user->can('create', Post::class)
        ) {
            $credentials = $postStoreRequest->only(['title', 'link']);
            $post = new Post($credentials);

            if ($data = $user->posts()->save($post)) {
                return $this->successResponse(
                    new PostResource(
                        $data->load(['user'])
                    )
                );
            }
        }

        return $this->errorResponse([], 'Create post error!');
    }

    /**
     * @param  PostRequest  $request
     * @param  $postId
     * @return JsonResponse
     */
    public function update(PostRequest $request, Post $post): JsonResponse
    {
        if (
            auth()->check()
            && auth()->user()->can('update', $post)
        ) {
            $credentials = $request->only(['title', 'link']);

            if ($post->update($credentials)) {
                return $this->successResponse(
                    new PostResource(
                        $post->load(['user', 'votes'])
                    )
                );
            }
        }

        return $this->errorResponse([], 'Update post error!');
    }

    /**
     * @param $postId
     * @return JsonResponse
     */
    public function delete(Post $post)
    {
        if (
            auth()->check()
            && auth()->user()->can('delete', $post)
        ) {
            if ($post->delete()) {
                return $this->successResponse([], 'Post  deleted successfully');
            }
        }

        return $this->errorResponse(null, 'Delete post error!');
    }
}
