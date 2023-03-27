<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepository;

/**
 * @OA\Tag(
 *     name="posts",
 *     description="Operations about posts"
 * )
 */
class PostController extends Controller
{
    public PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     tags={"Posts"},
     *     summary="Get post by ID",
     *     description="Returns a single post",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="successful"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
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
}
