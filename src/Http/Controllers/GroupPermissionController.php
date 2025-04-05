<?php

namespace ABMemon\SentinelRBAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ABMemon\SentinelRBAC\Models\Group;
use ABMemon\SentinelRBAC\Models\Permission;

class GroupPermissionController extends Controller
{
    public function sync(Request $request, $groupId)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $group = Group::findOrFail($groupId);
        $permissionIds = Permission::whereIn('name', $request->permissions)->pluck('id');

        $group->permissions()->sync($permissionIds);

        return response()->json(['message' => 'Group permissions synced successfully']);
    }
}
