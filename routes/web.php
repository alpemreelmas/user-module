<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\UserController;
use Modules\User\App\Http\Controllers\ProfileController;
use Modules\User\App\Http\Controllers\PermissionController;
use Modules\User\App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::group([], function () {

});*/

Route::group([], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix("user-management/")->as("user-management.")->group(function () {


    Route::prefix("users")->as("users.")->controller(UserController::class)->group(function () {
        Route::get("/", "index")->name("index")
            ->middleware("can:user_access");

        Route::middleware("can:user_create")->group(function () {
            Route::post("/", "store")->name("store");
            Route::get("/create", "create")->name("create");
        });


        Route::middleware("can:user_update")->group(function () {
            Route::get("{user}/edit", "edit")->name("edit");
            Route::put("/{user}", "update")->name("update");
        });

        Route::middleware("can:user_delete")->group(function () {
            Route::delete("/{user}", "destroy")->name("delete");
            Route::post("/{id}/restore", "restore")->name("restore");
        });

        Route::post("/{id}/force-delete", "forceDelete")
            ->name("forceDelete")->middleware("can:users_force_delete");

    });
    Route::prefix("permissions")->as("permissions.")->controller(PermissionController::class)->group(function () {
        Route::get("/", "index")->name("index")
            ->middleware("can:user_access");

        /*Route::middleware("can:users_create")->group(function () {
            Route::post("/", "store")->name("store");
            Route::get("/create", "create")->name("create");
        });*/


        Route::middleware("can:user_update")->group(function () {
            Route::get("{permission}/edit", "edit")->name("edit");
            Route::put("/{permission}", "update")->name("update");
        });

        /*            Route::middleware("can:user_delete")->group(function () {
                        Route::delete("/{user}", "destroy")->name("delete");
                        Route::post("/{id}/restore", "restore")->name("restore");
                    });

                    Route::post("/{id}/force-delete", "forceDelete")
                        ->name("forceDelete")->middleware("can:users_force_delete");*/

    });
    Route::prefix("roles")->as("roles.")->controller(RoleController::class)->group(function () {
        Route::get("/", "index")->name("index")
            ->middleware("can:user_access");

        Route::middleware("can:user_create")->group(function () {
            Route::post("/", "store")->name("store");
            Route::get("/create", "create")->name("create");
        });


        Route::middleware("can:user_update")->group(function () {
            Route::get("{role}/edit", "edit")->name("edit");
            Route::put("/{role}", "update")->name("update");
        });

        Route::middleware("can:user_delete")->group(function () {
            Route::delete("/{role}", "destroy")->name("delete");
        });

    });
});

require __DIR__ . '/auth.php';
