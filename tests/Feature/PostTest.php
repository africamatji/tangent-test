<?php

namespace Tests\Feature;

use App\Http\Requests\CreatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PostTest extends TestCase
{
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    public function test_endpoint_create_post(): void
    {
        $requestCreatePost = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'user_id' => User::first()->id,
            'category_id' => Category::first()->id,
        ];
        //validate request
        $request = new CreatePostRequest($requestCreatePost);
        $validator = Validator::make($request->all(), $request->rules());
        $this->assertTrue($validator->passes());

        $response = $this->post('/api/posts', $requestCreatePost);
        $response->assertJson(['message' => 'successful']);
        //check response
        $response->assertStatus(200);
        //check if record was created
        $this->assertDatabaseHas('posts', $requestCreatePost);
    }

    public function test_endpoint_get_posts(): void
    {
        $requestAllPosts = [
            [
                'title' => $this->faker->sentence,
                'body' => $this->faker->paragraph,
                'user_id' => User::first()->id,
                'category_id' => Category::first()->id,
            ],
            [
                'title' => $this->faker->sentence,
                'body' => $this->faker->paragraph,
                'user_id' => User::first()->id,
                'category_id' => Category::first()->id,
            ],
        ];
        //remove existing posts
        $this->truncatePosts();
        //create sample posts
        foreach ($requestAllPosts as $post) {
            Post::create($post);
        }
        //send request
        $response = $this->get('/api/posts');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'successful',
            'posts' => $requestAllPosts
        ]);
    }

    public function test_endpoint_find_post(): void
    {
        $id = Post::inRandomOrder()->first()->id;
        $post = Post::with(['comments', 'category', 'user'])->find($id)->first();
        $response = $this->get("/api/posts/{$id}");
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'successful',
            'posts' => [
                'id' => $post->id,
            ],
        ]);
    }

    public function test_endpoint_delete_post(): void
    {
        $id = Post::inRandomOrder()->first()->id;
        $response = $this->delete("/api/posts/{$id}");
        $posts = Post::find($id);
        $this->assertNull($posts);
        $response->assertStatus(200);
    }

    public function truncatePosts(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Post::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
