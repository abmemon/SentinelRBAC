<?php

namespace ABMemon\SentinelRBAC\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ABMemon\SentinelRBAC\Models\Group;

class GroupUserController extends Controller
{
    public function sync(Request $request, $groupId)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        $group = Group::findOrFail($groupId);
        $group->users()->sync($request->users);

        return response()->json(['message' => 'Group users synced successfully']);
    }
}
