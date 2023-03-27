<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    public PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function find(Request $request): JsonResponse
    {
        $post = $this->postRepository->find($request->id);

        return response()->json([
            'message' => 'successful',
            'posts' => $post
        ]);
    }

    public function create(CreatePostRequest $request): JsonResponse
    {
        $post = $this->postRepository->create($request->all());

        return response()->json([
            'message' => 'successful',
            'post' => $post
        ]);
    }

    public function all(): JsonResponse
    {
        $posts = $this->postRepository->all();

        return response()->json([
            'message' => 'successful',
            'posts' => $posts
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        $this->postRepository->delete($request->id);

        return response()->json(['message' => 'successful']);
    }

    public function update(UpdatePostRequest $request, $id): JsonResponse
    {
        $post = $this->postRepository->update($id, $request->all());

        return response()->json([
            'message' => 'successful',
            'post' => $post
        ]);
    }

    public function findByUser(Request $request): JsonResponse
    {
        $post = $this->postRepository->findByUser($request->id);

        return response()->json([
            'message' => 'successful',
            'post' => $post
        ]);
    }
}
