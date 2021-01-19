<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function indexPost()
    {   $users = User::factory()->make();
        $response = $this->actingAs($users)->get('http://127.0.0.1:8000/users');
        $response->assertStatus(403);
        Permission::create(['name' => 'user-list']);
        $role = Role::create(['name' => 'user']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $users->assignRole([$role->id]);
        $response = $this->actingAs($users)->get('http://127.0.0.1:8000/users');
        $response->assertStatus(403);
    }
}
