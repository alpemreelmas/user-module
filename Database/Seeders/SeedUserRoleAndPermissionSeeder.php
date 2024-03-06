<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
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
        self::createPermissions();

        /*$this->call(PermissionAndRoleSeeder::class);*/

        $superAdmin = User::factory()->create([
            'name' => 'Alp Emre Elmas',
            'email' => 'elmasalpemre@gmail.com',
        ]);

        $superAdmin->assignRole("Super Admin");
    }

    public static function createPermissions(): void
    {
        Permission::create(["name"=>"user_create"]);
        Permission::create(["name"=>"user_update"]);
        Permission::create(["name"=>"user_access"]);
        Permission::create(["name"=>"user_delete"]);
        Permission::create(["name"=>"user_force_delete"]);

        $role = Role::create(["name"=>"Super Admin","guard_name"=>"web"]);
        $permissions = Permission::all();

        foreach ($permissions as $permission){
            $role->givePermissionTo($permission);
        }
    }
}
