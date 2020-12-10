<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\posted;
//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
      * @test
      */
   public function user_can_visit_page_and_see_the_post()
   {
       $users=User::factory()->make();
       $response=$this->actingAs($users)->get('/posts');
       $response->assertStatus(200);
   }

    /**
     * @test
     */
    public function user_can_visit_post_and_create_the_post()
    {
        $users=User::factory()->make();
        $this->actingAs($users);
        $posts = posted::factory()->make(['user_id'=>$users->id]);
        $this->post('/create-post',$posts->toArray());
        $response=$this->get('/add-post');
        $response->assertOk();
    }

    /**
     * @test
     */
    public function user_can_edit_and_update_the_post()
    {
        $users=User::factory()->make();
        $this->actingAs($users);
        $posts = posted::factory()->create();
        $this->post('/update-post',$posts->toArray());
        $this->assertDatabaseHas('posteds',[ 'title' => $posts->title,'id'=>$posts->id,'description'=> $posts->description ,'posted_by'=> $posts->posted_by ]);
    }

    public function user_can_delete_the_post()
    {
        $users=User::factory()->make();
        $this->actingAs($users);
        $posts = posted::factory()->create();
        $this->get('/delete-post'.$posts->id);
        $this->assertDatabaseMissing('posted',['id'=> $posts->id]);
    }

}
