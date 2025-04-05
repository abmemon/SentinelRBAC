<?php

namespace ABMemon\SentinelRBAC\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'label'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'));
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
