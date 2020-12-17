<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;

class PostTest extends TestCase
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
    public function user_can_visit_page_and_see_the_post()
    {
        $users = User::factory()->make();
        $response = $this->actingAs($users)->get('posts');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function user_can_visit_post_and_create_store_the_post()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts = Post::factory()->make(['user_id' => $users->id]);
        $new_name ='4569875321326.png';
        Image::make(['post_id'=>$posts->id,
            'name'=>$new_name]);
        $this->post('posts', $posts->toArray());
        $response = $this->get('posts/create');
        $response->assertOk();
    }

    /**
     * @test
     */
    public function user_can_edit_and_update_the_post()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts = post::factory()->create();
        $this->get(' posts/'.$posts->id.'/edit ');
        $posts = Post::factory()->make(['id' => $posts->id]);
        $this->put('posts/' . $posts->id, $posts->toArray());
        $this->assertDatabaseHas('posts', ['title' => $posts->title, 'id' => $posts->id, 'description' => $posts->description, 'posted_by' => $posts->posted_by]);
    }

    /**
     * @test
     */
    public function user_can_delete_the_post()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts = Post::factory()->create();
        $this->delete('posts/'.$posts->id);
        $this->assertDeleted($posts);
    }
}
