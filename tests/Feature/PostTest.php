<?php

namespace Tests\Feature;

use App\Http\Requests\CreatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class PostTest extends TestCase
{
    public array $requestCreatePost = [];
    public array $requestAllPosts = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->requestCreatePost = [
            'title' => 'Title goes here',
            'body' => 'Lorem ipsum, body goes here too :)',
            'user_id' => User::first()->id,
            'category_id' => Category::first()->id,
        ];
        $this->requestAllPosts = [
            [
                'title' => 'First title foes here',
                'body' => 'First body goes here too :)',
                'user_id' => User::first()->id,
                'category_id' => Category::first()->id,
            ],
            [
                'title' => 'Second title goes here',
                'body' => 'Second body goes here too :)',
                'user_id' => User::first()->id,
                'category_id' => Category::first()->id,
            ],
        ];
    }

    public function test_endpoint_create_post(): void
    {
        //validate request
        $request = new CreatePostRequest($this->requestCreatePost);
        $validator = Validator::make($request->all(), $request->rules());
        $this->assertTrue($validator->passes());

        $response = $this->post('/api/posts', $this->requestCreatePost);
        $response->assertJson(['message' => 'successful']);
        //check response
        $response->assertStatus(200);
        //check if record was created
        $this->assertDatabaseHas('posts', $this->requestCreatePost);
    }

    public function test_endpoint_get_posts(): void
    {
        //remove existing posts
        $this->truncatePosts();
        //create sample posts
        foreach ($this->requestAllPosts as $post) {
            Post::create($post);
        }
        //send request
        $response = $this->get('/api/posts');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'successful',
            'posts' => $this->requestAllPosts
        ]);
    }

    public function test_endpoint_find_post(): void
    {
        $response = $this->get('/api/posts/1');
        $response->assertStatus(200);
    }

    public function truncatePosts(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Post::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
