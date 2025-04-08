<?php

namespace ABMemon\SentinelRBAC\Traits;

use ABMemon\SentinelRBAC\Models\Role;
use ABMemon\SentinelRBAC\Models\Permission;
use ABMemon\SentinelRBAC\Models\Group;

trait HasRolesAndPermissions
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function assignRole($role)
    {
        return $this->roles()->syncWithoutDetaching([$role->id ?? $role]);
    }

    public function givePermissionTo($permission)
    {
        return $this->permissions()->syncWithoutDetaching([$permission->id ?? $permission]);
    }

    public function hasRole(string $role)
    {
        return $this->roles->contains('name', $role);
    }

    public function hasPermission(string $permission)
    {
        return $this->getAllPermissionsCached()->contains($permission);
    }

    public function getAllPermissionsCached()
    {
        return cache()->remember("user_permissions_{$this->id}", 60, function () {
            $direct = $this->permissions->pluck('name');
            $fromRoles = $this->roles->flatMap->permissions->pluck('name');
            $fromGroups = $this->groups->flatMap->permissions->pluck('name');
            return $direct->merge($fromRoles)->merge($fromGroups)->unique();
        });
    }
}
