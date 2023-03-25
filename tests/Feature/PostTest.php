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
        $requestData = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'user_id' => User::first()->id,
            'category_id' => Category::first()->id,
        ];
        //validate request
        $request = new CreatePostRequest($requestData);
        $validator = Validator::make($request->all(), $request->rules());
        $this->assertTrue($validator->passes());

        $response = $this->post('/api/posts', $requestData);
        $response->assertJson(['message' => 'successful']);
        //check response
        $response->assertStatus(200);
        //check if record was created
        $this->assertDatabaseHas('posts', $requestData);
    }

    public function test_endpoint_get_posts(): void
    {
        $request = [
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
        foreach ($request as $post) {
            Post::create($post);
        }
        //send request
        $response = $this->get('/api/posts');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'successful',
            'posts' => $request
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

    public function test_endpoint_update_post(): void
    {
        $request = [
            'title' => 'updated ' . $this->faker->sentence,
            'body' => 'updated ' . $this->faker->paragraph,
        ];
        $id = Post::inRandomOrder()->first()->id;
        $response = $this->put("/api/posts/{$id}", $request);
        $post = Post::find($id);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'successful',
            'post' => [
                'title' => $post->title,
                'body' => $post->body,
            ],
        ]);
    }

    public function truncatePosts(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Post::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
