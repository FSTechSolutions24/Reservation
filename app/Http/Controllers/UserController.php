<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:assign_permissions_to_user')->only(['assignPermissionsToUser']);
    //     $this->middleware('permission:view_permission')->only(['assignRoleToUser']);
    //     $this->middleware('permission:create_admin')->only(['createAdmin']);
    // }

    public function assignRoleToUser(Request $request, User $user)
    {
        // Validate the input
        $request->validate([
            'role' => 'required|exists:roles,name', // Ensure the role exists in the roles table
        ]);

        // Assign the role to the user
        $user->assignRole($request->role);

        // Return a response
        return response()->json([
            'message' => 'Role assigned successfully.',
            'roles' => $user->getRoleNames(),
        ]);
    }

    public function assignPermissionsToUser(Request $request, User $user)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'integer|exists:permissions,id'
        ]);

        $user->givePermissionTo($request->permissions);

        return response()->json([
            'message' => 'Permissions assigned successfully.',
            'permissions' => $user->getPermissionNames(),
        ]);
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'a',
        ]);

        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
    }

}
