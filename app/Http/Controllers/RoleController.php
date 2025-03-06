<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        // $adminRole = Role::create(['name' => 'admin']);
        // $userRole = Role::create(['name' => 'user']);
        // $createPostPermission = Permission::create(['name' => 'create posts']);
        // $editPostPermission = Permission::create(['name' => 'edit posts']);
        // $deletePostPermission = Permission::create(['name' => 'delete posts']);
        // $adminRole->givePermissionTo([$createPostPermission, $editPostPermission, $deletePostPermission]);
        // $userRole->givePermissionTo($createPostPermission);
        $user = User::find(1); // Find the user
        $user->assignRole('admin'); // Assign the 'admin' role
        dd('done');
    }
}
