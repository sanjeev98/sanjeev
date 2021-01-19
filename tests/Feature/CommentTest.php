<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Str;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function showPage()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts = Post::factory()->create();
        $response = $this->get('posts/' . $posts->id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function storeComment()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts = Post::factory()->create();
        $comment = Comment::create(['post_id' => $posts->id, 'comment' => $this->faker->paragraph]);
        $response = $this->json('POST', 'http://127.0.0.1:8000/posts/comments', ['post_id' => $comment->post_id, 'comment' => $comment->comment]);
        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'post_id' => $comment->post_id, 'comment' => $comment->comment]);
        $response->assertStatus(200);
        $this->failedDueToCommentValidation();
    }

    /**
     * @test
     */
    public function updateComment()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $posts = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $posts->id, 'comment' => $this->faker->paragraph]);
        $response = $this->get('posts/comments/' . $comment->id . '/edit');
        $response->assertExactJson($comment->toArray());
        $new_comment = $this->faker->paragraph;
        $response = $this->put('posts/comments/' . $comment->id, ['id' => $comment->id, 'comment' => $new_comment]);
        $updatecomment = Comment::factory()->make(['id' => $comment->id, 'post_id' => $posts->id,
            'comment' => $new_comment]);
        $this->assertDatabaseHas('comments', $updatecomment->toArray());
        $updatecomment = Comment::find($updatecomment->id);
        $response->assertExactJson($updatecomment->toArray());
        $this->failedDueToCommentValidation();
    }

    /**
     * @test
     */
    public function deleteComment()
    {
        $users = User::factory()->make();
        $this->actingAs($users);
        $comment = Comment::factory()->create();
        $response = $this->delete('posts/comments/' . $comment->id);
        $this->assertDeleted($comment);
        $response->assertExactJson(['success' => 'comment deleted!']);
    }

    /**
     * Validation for comment input.
     */
    public function failedDueToCommentValidation()
    {
        $response = $this->json('post', 'http://127.0.0.1:8000/posts/comments', ['comment' => '']);
        $response->assertExactJson([
            "errors" => ["comment" => ["The comment field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response = $this->json('post', 'http://127.0.0.1:8000/posts/comments', ['comment' => str::random(2)]);
        $response->assertExactJson([
            "errors" => ["comment" => ["The comment must be at least 3 characters."]],
            "message" => "The given data was invalid."
        ]);
        $response = $this->json('post', 'http://127.0.0.1:8000/posts/comments', ['comment' => str::random(266)]);
        $response->assertExactJson([
            "errors" => ["comment" => ["The comment may not be greater than 255 characters."]],
            "message" => "The given data was invalid."
        ]);
    }
}

