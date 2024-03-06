<?php

namespace Modules\User\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\App\Http\Requests\Role\StoreRoleRequest;
use Modules\User\App\Http\Requests\Role\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view("user::roles.index",compact("roles"));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view("user::roles.create",compact("permissions"));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());
        $role->syncPermissions($request->only("permissions")["permissions"]);
        return to_route("user-management.roles.index")->with("success","Role has been created.");
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view("user::roles.edit",compact("permissions","role"));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        /* TODO : check if you can make this more efficient */
        $role->update($request->validated());
        $role->syncPermissions($request->only("permissions")["permissions"]);
        return to_route("user-management.roles.index");
    }

    public function destroy(Request $request, Role $role)
    {
        if($role->users->count() > 0){
            return redirect()->back()->withErrors("This role is in use. Before remove role, please detach role from the users.");
        }
        $role->delete();
        return to_route("user-management.roles.index")->with("success","Role has been removed");
    }
}
