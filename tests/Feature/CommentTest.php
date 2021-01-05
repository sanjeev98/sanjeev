<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;


    /**
     * @test
     */
    public function user_can_visit_page()
    {
        $users = User::factory()->make();
        $response = $this->actingAs($users)->get('posts');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function user_can_create_store_the_()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts = Post::factory()->make(['user_id' => $users->id]);
        $new_name = 'hekk';
        $comment = Comment::make(['post_id' => $posts->id,
            'comment' => $new_name]);
        $this->post('posts/comments/{id}', $comment->toArray());
        $response = $this->get('posts/create');
        $response->assertOk();
    }

    /**
     * @test
     */
    public function user_can_edit_and_update_the_comment()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts = Post::factory()->create();
        $this->get(' posts/comments/' . $posts->id . '/edit ');
        $comment = Comment::factory()->create(['post_id' => $posts->id,
            'comment' => 'jhvd']);
        $this->put('posts/comments/' . $posts->id, $comment->toArray());
        $this->assertDatabaseHas('coments', ['post_id' => $comment->post_id, 'id' => $comment->id, 'comment' => $comment->comment]);
    }

    /**
     * @test
     */
    public function user_can_delete_the_comment()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $comment = Comment::factory()->create();
        $this->delete('posts/comments/' . $comment->id);
        $this->assertDeleted($comment);
    }
}
