<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedUserRoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /* User's permissions list */
        Permission::create(["name"=>"user_create"]);
        Permission::create(["name"=>"user_update"]);
        Permission::create(["name"=>"user_access"]);
        Permission::create(["name"=>"user_delete"]);
        Permission::create(["name"=>"user_force_delete"]);

        $superAdminRole = Role::create(["name"=>"Super Admin","guard_name"=>"web"]);

        $permissions = Permission::all();

        foreach ($permissions as $permission){
            $superAdminRole->givePermissionTo($permission);
        }

        /*$this->call(PermissionAndRoleSeeder::class);*/

        $superAdmin = User::factory()->create([
            'name' => 'Alp Emre Elmas',
            'email' => 'elmasalpemre@gmail.com',
        ]);

        $superAdmin->assignRole("Super Admin");
    }
}
