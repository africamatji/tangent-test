<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;

class PostController extends Controller
{

    public function create(CreatePostRequest $request): JsonResponse
    {
        $post = Post::create($request->all());

        return response()->json([
            'message' => 'successful',
            'post' => $post
        ]);
    }

    public function all(): JsonResponse
    {
        $posts = Post::all();

        return response()->json([
            'message' => 'successful',
            'posts' => $posts
        ]);
    }

    public function find(Request $request): JsonResponse
    {
        $post = Post::with(['comments', 'category', 'user'])->find($request->id)->first();

        return response()->json([
            'message' => 'successful',
            'posts' => $post
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        $post = Post::find($request->id);
        if($post) {
            $post->comments()->delete();
            $post->delete();
        }

        return response()->json(['message' => 'successful']);
    }

    public function update(Request $request): JsonResponse
    {

        return response()->json([]);
    }
}
