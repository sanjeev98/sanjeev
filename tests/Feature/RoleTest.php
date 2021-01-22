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

class RoleTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function indexRole()
    {
        //User does not have role-list permission case
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('http://127.0.0.1:8000/roles');
        $response->assertStatus(403);
        //success case
        Permission::create(['name' => 'role-list']);
        $role = Role::create(['name' => $this->faker->name]);
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        $response = $this->actingAs($user)->get('http://127.0.0.1:8000/roles');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function storeUserRole()
    {
        //User does not have role-creat permission case
        $user = User::factory()->create();
        $role_name = $this->faker->name;
        $permission = Permission::create(['name' => 'role-create']);
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/roles', ['role' => $role_name, 'permissions' => $permission->id]);
        $response->assertStatus(403);
        //Success case
        $role = Role::create(['name' => $this->faker->name]);
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        $response = $this->actingAs($user)->json('POST', 'http://127.0.0.1:8000/roles', ['role' => $role_name, 'permissions' => $permission->id]);
        $this->assertDatabaseHas('roles', ['name' => $role->name]);
        $this->assertDatabaseHas('role_has_permissions', ['role_id' => $role->id, 'permission_id' => $permission->id]);
        $response->assertStatus(302);
        $this->failedDueToRole($role, $permission);
        $this->failedDueToPermission();
    }

    /**
     * @test
     */
    public function updateUserRole()
    {
        //User does not have role-edit permission case
        $user = User::factory()->create();
        $role_name = $this->faker->name;
        $this->actingAs($user);
        $role = Role::create(['name' => $role_name]);
        $permission = Permission::create(['name' => 'role-edit']);
        $response = $this->put('roles/' . $role->id, ['role' => $role_name, 'permissions' => $permission->id]);
        $response->assertStatus(403);
        //Success case
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        $response = $this->put('roles/' . $role->id, ['role' => $role_name, 'permissions' => $permission->id]);
        $this->assertDatabaseHas('roles', ['name' => $role->name]);
        $this->assertDatabaseHas('role_has_permissions', ['role_id' => $role->id, 'permission_id' => $permission->id]);
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function deleteRole()
    {
        //User does have role-delete permission case
        $user = User::factory()->create();
        $role_name = $this->faker->name;
        Permission::create(['name' => 'role-delete']);
        $role = Role::create(['name' => $role_name]);
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        $this->actingAs($user);
        $response = $this->delete('roles/' . $role->id);
        $this->assertDeleted($role);
        $response->assertOk();
        $response->assertExactJson(['success' => 'Role deleted successfully']);
    }

    /**
     * Validation for Role input.
     */
    public function failedDueToRole($role, $permission)
    {
        //Failed due to role already exists in table
        $response = $this->json('POST', 'http://127.0.0.1:8000/roles', ['role' => $role->name, 'permissions' => $permission->id]);
        $response->assertExactJson([
            "errors" => ["role" => ["The role has already been taken."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        //Failed due to role field required
        $response = $this->json('POST', 'http://127.0.0.1:8000/roles', ['permissions' => $permission->id]);
        $response->assertExactJson([
            "errors" => ["role" => ["The role field is required."]],
            "message" => "The given data was invalid."
        ]);
        //Failed due to role min length testcase
        $response->assertStatus(422);
        $response = $this->json('POST', 'http://127.0.0.1:8000/roles', ['role' => str::random(2), 'permissions' => $permission->id]);
        $response->assertExactJson([
            "errors" => ["role" => ["The role must be at least 3 characters."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        //Failed due to role max length testcase
        $response = $this->json('POST', 'http://127.0.0.1:8000/roles', ['role' => str::random(22), 'permissions' => $permission->id]);
        $response->assertExactJson([
            "errors" => ["role" => ["The role may not be greater than 20 characters."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
    }

    /**
     * Validation for permission input.
     */
    public function failedDueToPermission()
    {
        //Failed due to permission field is required
        $response = $this->json('POST', 'http://127.0.0.1:8000/roles', ['role' => str::random(5), 'permissions' => '']);
        $response->assertExactJson([
            "errors" => ["permissions" => ["The permissions field is required."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
        //Failed due to permission doesn't exists in the table
        $response = $this->json('POST', 'http://127.0.0.1:8000/roles', ['role' => str::random(5), 'permissions' => '20']);
        $response->assertExactJson([
            "errors" => ["permissions" => ["The selected permissions is invalid."]],
            "message" => "The given data was invalid."
        ]);
        $response->assertStatus(422);
    }
}
