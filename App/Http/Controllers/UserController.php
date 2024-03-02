<?php

namespace Modules\User\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Modules\User\App\Http\Requests\User\StoreUserRequest;
use Modules\User\App\Http\Requests\User\UpdateUserRequest;
use Modules\User\App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $onlyTrashed = request()->query("only_trashed");
        $users = User::with("roles")->when($onlyTrashed,function ($query){
            $query->onlyTrashed();
        })->get();
        return view("user::users.index",compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view("user::users.create",compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole($request->roles);
        return to_route("user::users.index")->with("success","Successfully created.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view("user::users.edit",compact("user","roles"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->fill($request->safe(["email","name"]));
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user->syncRoles($request->roles);
        return to_route("user::users.index")->with("success","Successfully updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with("success","Successfully deleted.");
    }

    public function restore($id)
    {
        $user = User::withTrashed()->where("id",$id)->firstOrFail();
        $user->restore();
        return redirect()->back()->with("success","Successfully restored.");
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->where("id",$id)->firstOrFail();
        $user->forceDelete();
        return redirect()->back()->with("success","Successfully forced to delete.");
    }
}
