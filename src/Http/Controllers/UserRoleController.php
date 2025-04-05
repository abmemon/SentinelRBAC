<?php

namespace ABMemon\SentinelRBAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ABMemon\SentinelRBAC\Models\Role;

class UserRoleController extends Controller
{
    public function sync(Request $request, $userId)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $userModel = config('auth.providers.users.model');
        $user = $userModel::findOrFail($userId);
        $roleIds = Role::whereIn('name', $request->roles)->pluck('id');

        $user->roles()->sync($roleIds);

        return response()->json(['message' => 'Roles synced successfully']);
    }
}
