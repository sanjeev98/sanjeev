<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function indexUser()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('http://127.0.0.1:8000/users');
        $response->assertStatus(403);
        Permission::create(['name' => 'user-list']);
        $role = Role::create(['name' => $this->faker->name]);
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        $response = $this->actingAs($user)->get('http://127.0.0.1:8000/users');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function storeUserRole()
    {
        $user = User::factory()->create();
        $role_name = $this->faker->name;
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/users', ['user_id' => $user->id, 'roles' => $role_name]);
        $response->assertStatus(403);
        Permission::create(['name' => 'user-create']);
        $role = Role::create(['name' => $role_name]);
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/users', ['user_id' => $user->id, 'roles' => $role_name]);
        $this->assertDatabaseHas('roles', ['name' => $role->name]);
        $this->assertDatabaseHas('model_has_roles', ['role_id' => $role->id, 'model_id' => $user->id]);
        $response->assertStatus(302);
        $this->failedDueToUserId($user, $role_name);
        $this->failedDueToRoles($user);
    }

    /**
     * @test
     */
    public function updateUserRole()
    {
        $user = User::factory()->create();
        $role_name = $this->faker->name;
        $this->actingAs($user);
        $response = $this->put('users/' . $user->id, ['roles' => $role_name]);
        $response->assertStatus(403);
        Permission::create(['name' => 'user-edit']);
        $role = Role::create(['name' => $role_name]);
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        $response = $this->put('users/' . $user->id, ['roles' => $role_name]);
        $this->assertDatabaseHas('roles', ['name' => $role->name]);
        $this->assertDatabaseHas('model_has_roles', ['role_id' => $role->id, 'model_id' => $user->id]);
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function deleteUser()
    {
        $user = User::factory()->create();
        $role_name = $this->faker->name;
        Permission::create(['name' => 'user-delete']);
        $role = Role::create(['name' => $role_name]);
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        $this->actingAs($user);
        $response = $this->delete('users/' . $user->id);
        $this->assertDeleted($user);
        $response->assertOk();
        $response->assertExactJson(['success' => 'User deleted successfully']);
    }

    /**
     * Validation for user_id input.
     */
    public function failedDueToUserId($user, $role_name)
    {
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/users');
        $response->assertExactJson([
            "errors" => ["user_id" => ["The user id field is required."],
                "roles" => ["The roles field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/users', ['user_id' => '', 'roles' => $role_name]);
        $response->assertExactJson([
            "errors" => ["user_id" => ["The user id field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/users', ['user_id' => '1', 'roles' => $role_name]);
        $response->assertExactJson([
            "errors" => ["user_id" => ["The selected user id is invalid."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/users', ['user_id' => $this->faker->randomNumber, 'roles' => $role_name]);
        $response->assertExactJson([
            "errors" => ["user_id" => ["The selected user id is invalid."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
    }

    /**
     * Validation for roles input.
     */
    public function failedDueToRoles($user)
    {
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/users', ['user_id' => $user->id, 'roles' => '']);
        $response->assertExactJson([
            "errors" => ["roles" => ["The roles field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/users', ['user_id' => $user->id, 'roles' => $this->faker->name]);
        $response->assertExactJson([
            "errors" => ["roles" => ["The selected roles is invalid."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/users', ['user_id' => $user->id, 'roles' => 'Admin']);
        $response->assertExactJson([
            "errors" => ["roles" => ["The selected roles is invalid."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
    }
}
