<?php

namespace ABMemon\SentinelRBAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ABMemon\SentinelRBAC\Models\Permission;

class UserPermissionController extends Controller
{
    public function sync(Request $request, $userId)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $userModel = config('auth.providers.users.model');
        $user = $userModel::findOrFail($userId);
        $permissionIds = Permission::whereIn('name', $request->permissions)->pluck('id');

        $user->permissions()->sync($permissionIds);

        return response()->json(['message' => 'Permissions synced successfully']);
    }
}
