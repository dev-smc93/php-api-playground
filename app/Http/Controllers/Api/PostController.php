<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    /**
     * 게시글 목록 조회
     */
    public function index(): AnonymousResourceCollection
    {
        $posts = Post::query()->orderByDesc('created_at')->get();

        return PostResource::collection($posts);
    }

    /**
     * 게시글 생성
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $post = Post::query()->create($request->validated());

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * 게시글 상세 조회
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    /**
     * 게시글 수정
     */
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $post->update($request->validated());

        return new PostResource($post->fresh());
    }

    /**
     * 게시글 삭제
     */
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
