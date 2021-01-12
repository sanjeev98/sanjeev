<?php

namespace Tests\Feature;

use App\Http\Resources\v1\PostResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class PostApiTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected $user;
    /**
     * @test
     */
    public function authenticate()
    {
        $user = User::factory()->create();
        $response = $this->post('api/auth/login',['email'=>$user->email, 'password'=> 'Password@123']);
        $this->user =$user;
        $token = JWTAuth::fromUser($user);
        $this->actingAs($user,'api');
        $response->assertStatus(200);
        return $token;
    }

    /**
     * @test
     */
    public function storePost()
    {
        $token=$this->authenticate();
        $post = Post::factory()->create();
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('POST', 'http://127.0.0.1:8000/api/auth/v1/posts', ['title' => $post->title, 'description' => $post->description]);
        $this->assertDatabaseHas('posts', ['title' => $post->title, 'id' => $post->id, 'user_id' => $post->user_id, 'description' => $post->description, 'posted_by' => $post->posted_by]);
        $response->assertStatus(422);
        $this->failedDueToTitleValidations($token);
        $this->failedDueToDescriptionValidations($token);
    }

    /**
     * @test
     */
    public function updatePost()
    {
        $token=$this->authenticate();
        $posts = Post::factory()->create();
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->put('http://127.0.0.1:8000/api/auth/v1/posts/' . $posts->id, ['title' => $posts->title, 'description' => $posts->description]);
        $this->assertDatabaseHas('posts', ['title' => $posts->title, 'id' => $posts->id, 'user_id' => $posts->user_id, 'description' => $posts->description, 'posted_by' => $posts->posted_by]);
        $posts['message'] = 'Post Updated Successfully';
        $resource = new PostResource($posts);
        $resource =$resource->response()->getData(true);
        $temp=$response->json();
        $this->assertEquals($temp,$resource);
        $response->assertStatus(200);
        $this->failedDueToTitleValidations($token);
        $this->failedDueToDescriptionValidations($token);
    }

    /**
     * @test
     */
    public function deletePost()
    {
        $token=$this->authenticate();
        $posts = Post::factory()->create();
        $response = $this->delete('http://127.0.0.1:8000/api/auth/v1/posts/' . $posts->id);
        $this->assertDeleted($posts);
        $response->assertOk();
        $post['message'] = 'Post Successfully Deleted';
        $resource = new PostResource($post);
        $resource =$resource->response()->getData(true);
        $temp=$response->json();
        $this->assertEquals($temp,$resource);
    }

    /**
     * Validation for title input.
     */
    public function failedDueToTitleValidations($token)
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('POST', 'http://127.0.0.1:8000/api/auth/v1/posts', ['title' => '']);
        $response->assertExactJson([
            "errors" => ["description" => ["The description field is required."],
                "title" => ["The title field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('POST', 'http://127.0.0.1:8000/api/auth/v1/posts', ['title' => str::random(2)]);
        $response->assertExactJson([
            "errors" => ["description" => ["The description field is required."],
                "title" => ["The title must be at least 3 characters."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('post', 'http://127.0.0.1:8000/api/auth/v1/posts', ['title' => Str::random(300)]);
        $response->assertExactJson([
            "errors" => ["description" => ["The description field is required."],
                "title" => ["The title may not be greater than 255 characters."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('post', 'http://127.0.0.1:8000/api/auth/v1/posts', ['title' => str::random(2), 'description' => $this->faker->text]);
        $response->assertExactJson([
            "errors" => ["title" => ["The title must be at least 3 characters."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('post', 'http://127.0.0.1:8000/api/auth/v1/posts', ['title' => Str::random(300), 'description' => $this->faker->text]);
        $response->assertExactJson([
            "errors" => ["title" => ["The title may not be greater than 255 characters."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
    }

    /**
     * Validation for description input.
     */
    public function failedDueToDescriptionValidations($token)
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('post', 'http://127.0.0.1:8000/api/auth/v1/posts', ['description' => '']);
        $response->assertExactJson([
            "errors" => ["description" => ["The description field is required."],
                "title" => ["The title field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('post', 'http://127.0.0.1:8000/api/auth/v1/posts', ['description' => Str::random(2)]);
        $response->assertExactJson([
            "errors" => ["description" => ["The description must be at least 10 characters."],
                "title" => ["The title field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('post', 'http://127.0.0.1:8000/api/auth/v1/posts', ['description' => Str::random(300)]);
        $response->assertExactJson([
            "errors" => ["description" => ["The description may not be greater than 255 characters."],
                "title" => ["The title field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('post', 'http://127.0.0.1:8000/api/auth/v1/posts', ['title' => $this->faker->name, 'description' => Str::random(2)]);
        $response->assertExactJson([
            "errors" => ["description" => ["The description must be at least 10 characters."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->json('post', 'http://127.0.0.1:8000/api/auth/v1/posts', ['title' => $this->faker->name, 'description' => Str::random(300)]);
        $response->assertExactJson([
            "errors" => ["description" => ["The description may not be greater than 255 characters."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
    }
}
