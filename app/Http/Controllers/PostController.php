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

    /**
     * @OA\Post(
     *     path="/posts",
     *     summary="Create a new post",
     *     description="Creates a new post with the given title, body, user ID, and category ID",
     *     operationId="createPost",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Post object to be created",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"title", "body", "user_id", "category_id"},
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     example="Example title"
     *                 ),
     *                 @OA\Property(
     *                     property="body",
     *                     type="string",
     *                     example="Example body"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example=4
     *                 ),
     *                 @OA\Property(
     *                     property="category_id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="A success message",
     *                 example="successful"
     *             ),
     *         )
     *     )
     * )
     */
    public function create(CreatePostRequest $request): JsonResponse
    {
        $post = $this->postRepository->create($request->all());

        return response()->json([
            'message' => 'successful',
            'post' => $post
        ]);
    }

    /**
     * @OA\Get(
     *   path="/posts",
     *   summary="Get all posts",
     *   tags={"Posts"},
     *   @OA\Response(
     *     response="200",
     *     description="List of posts",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="successful"
     *       ),
     *       @OA\Property(
     *         property="posts",
     *         type="array",
     *         @OA\Items(
     *           @OA\Property(
     *             property="id",
     *             type="integer",
     *             example=1
     *           ),
     *           @OA\Property(
     *             property="title",
     *             type="string",
     *             example="Example title"
     *           ),
     *           @OA\Property(
     *             property="body",
     *             type="string",
     *             example="Example body"
     *           ),
     *           @OA\Property(
     *             property="user_id",
     *             type="integer",
     *             example=4
     *           ),
     *           @OA\Property(
     *             property="category_id",
     *             type="integer",
     *             example=1
     *           )
     *         )
     *       )
     *     )
     *   )
     * )
     */
    public function all(): JsonResponse
    {
        $posts = $this->postRepository->all();

        return response()->json([
            'message' => 'successful',
            'posts' => $posts
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     operationId="deletePost",
     *     tags={"Posts"},
     *     summary="Delete a post by ID",
     *     description="Deletes a post by ID from the database.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="successful"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Post not found"
     *             )
     *         )
     *     )
     * )
     */
    public function delete(Request $request): JsonResponse
    {
        $this->postRepository->delete($request->id);

        return response()->json(['message' => 'successful']);
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     operationId="updatePost",
     *     tags={"Posts"},
     *     summary="Update a post by ID",
     *     description="Updates a post by ID in the database.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Post object that needs to be updated",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="updated title"),
     *             @OA\Property(property="body", type="string", example="Update body here"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="successful"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Post not found"
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdatePostRequest $request, $id): JsonResponse
    {
        $post = $this->postRepository->update($id, $request->all());

        return response()->json([
            'message' => 'successful',
            'post' => $post
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     operationId="findPostsByUser",
     *     tags={"Posts"},
     *     summary="Find posts by user ID",
     *     description="Finds all posts created by a specific user.",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ID of the user to find posts for",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="successful"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="User not found"
     *             )
     *         )
     *     )
     * )
     */
    public function findByUser(Request $request): JsonResponse
    {
        $post = $this->postRepository->findByUser($request->id);

        return response()->json([
            'message' => 'successful',
            'post' => $post
        ]);
    }
}
