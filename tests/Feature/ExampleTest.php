<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function indexPost()
    {
        $users = User::factory()->make();
        $response = $this->actingAs($users)->get('posts');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function storePost()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts=Post::factory()->create();
        $response = $this->json('POST', 'http://127.0.0.1:8000/posts', ['user_id' => $posts->user_id, 'title' => $posts->title, 'description' => $posts->description, 'posted_by' => $posts->posted_by]);
        $this->assertDatabaseHas('posts', ['title' => $posts->title, 'id' => $posts->id, 'user_id' => $posts->user_id, 'description' => $posts->description, 'posted_by' => $posts->posted_by]);
        $response
            ->assertRedirect('posts');
        $this->failedDueToTitleValidations();
        $this->failedDueToDescriptionValidations();
    }

    /**
     * @test
     */
    public function updatePost()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts = post::factory()->create();
        $response=$this->put('posts/' . $posts->id,['id' => $posts->id,'title' => $posts->title, 'description' => $posts->description, 'posted_by' => $posts->posted_by]);
        $this->assertDatabaseHas('posts', ['title' => $posts->title, 'id' => $posts->id, 'user_id' => $posts->user_id, 'description' => $posts->description, 'posted_by' => $posts->posted_by]);
        $response->assertOk();
        $response->assertExactJson(['success'=>'Post updated successfully!']);

    }

    /**
     * @test
     */
    public function user_can_delete_the_post()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts = Post::factory()->create();
        $response=$this->delete('posts/'.$posts->id);
        $this->assertDeleted($posts);
        $response->assertOk();
        $response->assertExactJson(['success'=>'Customer deleted!']);
    }

    public function failedDueToTitleValidations()
    {
        $response = $this->json('post', 'http://127.0.0.1:8000/posts', ['title' => '']);
        $response->assertExactJson([
            "errors" => ["description" => ["The description field is required."],
            "posted_by" =>["The posted by field is required."],
            "title" => ["The title field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
    }
    public function failedDueToDescriptionValidations()
    {
        $response = $this->json('post', 'http://127.0.0.1:8000/posts', ['description' => '']);
        $response->assertExactJson([
            "errors" => ["description" => ["The description field is required."],
                "posted_by" =>["The posted by field is required."],
                "title" => ["The title field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
    }
}
