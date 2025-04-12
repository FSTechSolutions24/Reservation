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

    public function assignPermissionsToUser(User $user, $permissions)
    {
        $validatedPermissions = validator([
            'permissions' => $permissions
        ], [
            'permissions' => 'required|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ])->validate();
    
        // Assign permissions to the user
        $user->syncPermissions($validatedPermissions['permissions']);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'user_type' => 'required|in:a,u',
        ]);

        if(!$this->can_do_action($request->user_type, 'create')){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);

        if ($request->has('permissions')) {
            $this->assignPermissionsToUser($user, $request->permissions);
        }

        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);
    
        if (!$this->can_do_action($user->user_type, 'update')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $user->name = $request->name;
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        if ($request->has('permissions')) {
            $this->assignPermissionsToUser($user, $request->permissions);
        }

        $user->save();
    
        return response()->json(['user' => $user], 200);
    }

    public function can_do_action($type, $action){
        $permissionMap = [
            'a' => [ 'create' => 'create_admin', 'update' => 'edit_admin' ],
            'u' => [ 'create' => 'create_user', 'update' => 'edit_user' ],
        ];
    
        $permission = $permissionMap[$type][$action] ?? null;
    
        if (!$permission) {
            return false;
        }
    
        return Auth::user()->can($permission, 'api');
    }

}
