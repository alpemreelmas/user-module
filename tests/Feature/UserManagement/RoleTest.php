<?php

namespace Modules\User\Tests\Feature\UserManagement;

use Illuminate\Database\Eloquent\Model;
use Modules\User\App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Database\Seeders\SeedUserRoleAndPermissionSeeder;
use PHPUnit\Util\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        SeedUserRoleAndPermissionSeeder::createPermissions();
    }

    public function test_role_index_page_rendered(): void
    {
        $user = User::factory()->create();
        $user->assignRole("Super Admin");


        $response = $this->actingAs($user)->get("/user-management/roles");

        $response->assertStatus(200);
    }

    public function test_role_index_page_shouldnt_rendered_if_invalid_role(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get("/user-management/roles");

        $response->assertForbidden();
    }

    public function test_role_create_page_rendered(): void
    {
        $user = User::factory()->create();
        $user->assignRole("Super Admin");

        $response = $this->actingAs($user)->get('/user-management/roles/create');

        $response->assertSeeText("Select All")->assertStatus(200);
    }

    public function test_role_create_with_invalid_credentials(): void
    {
        $user = User::factory()->create();
        $user->assignRole("Super Admin");
        $response = $this->actingAs($user)->post('/user-management/roles',[
            "name"=>"Super Admin",
            "permissions" => [
                "user_access"
            ]
        ]);

        $response->assertSessionHasErrors(["name"]);
    }

    public function test_role_create_with_valid_credentials(): void
    {
        $user = User::factory()->create();
        $user->assignRole("Super Admin");
        $response = $this->actingAs($user)->post('/user-management/roles',[
            "name" => "Test Role",
            "permissions" => [
                "user_access"
            ]
        ]);

        $response->assertSessionHas("success")->assertRedirect("/user-management/roles");
    }

    public function test_role_edit_page_should_rendered(): void
    {
        $user = User::factory()->create();
        $user->assignRole("Super Admin");
        $response = $this->actingAs($user)->get('/user-management/roles/'. $user->roles()->pluck("id")[0] .'/edit');

        $response->assertSeeText("Super Admin")->assertStatus(200);
    }

    public function test_role_update_with_invalid_credentials(): void
    {
        $user = User::factory()->create();
        $user->assignRole("Super Admin");
        $response = $this->actingAs($user)->put('/user-management/roles/'. $user->roles()->pluck("id")[0],[
            "name" => "Super Admin",
            "permissions" => []
        ]);

        $response->assertSessionHasErrors(["permissions"]);
    }

    public function test_role_can_not_be_deleted_if_any_user_has_the_role(): void
    {
        $user = User::factory()->create();
        $user->assignRole("Super Admin");
        $response = $this->actingAs($user)->delete('/user-management/roles/'. $user->roles()->pluck("id")[0]);

        $response->assertSessionHasErrors();
    }

    public function test_role_can_be_deleted_if_no_one_has_the_role(): void
    {
        $user = User::factory()->create();
        $user->assignRole("Super Admin");
        $role = Role::create(["name"=> "Test Role","guard_name" => "web"]);
        $response = $this->actingAs($user)->delete('/user-management/roles/'. $role->id);

        $response->assertSessionHas("success")->assertRedirect("/user-management/roles");
    }
}
